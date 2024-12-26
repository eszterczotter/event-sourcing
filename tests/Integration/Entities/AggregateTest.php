<?php

use Tests\Integration\Dummies\TestAggregate;
use Tests\Integration\Dummies\TestAggregateWithDependencies;
use Tests\Integration\Dummies\TestAggregateWithSegregates;
use Tests\Integration\Dummies\TestId;
use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Entities\Aggregate;
use Webmaesther\EventSourcing\Model\Event;
use Webmaesther\EventSourcing\Serializers\EventSerializer;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

describe(Aggregate::class, function () {

    it('is abstract', function () {

        expect(Aggregate::class)->toBeAbstract();

    });

    it('has only the specified public methods', function () {

        expect(Aggregate::class)->not->toHavePublicMethodsBesides(['record', 'retrieve', 'save']);

    });

    it('records events internally', function () {

        $aggregate = TestAggregate::retrieve('uuid');

        $result = $aggregate->doSomething();

        expect($result)->toBe($aggregate)
            ->and($aggregate->events)->toEqual([new TestEvent]);
        assertDatabaseEmpty(Event::class);

    });

    it('creates a new instance of its child', function () {

        expect(TestAggregate::retrieve('id'))
            ->toBeInstanceOf(TestAggregate::class);

    });

    it('holds a reference to the id', function () {

        $id = 'id';

        $aggregate = TestAggregate::retrieve($id);

        expect($aggregate->id)->toBe($id);

    });

    it('applies events to itself', function () {

        $aggregate = TestAggregate::retrieve('ulid');

        $aggregate->doSomething();

        expect($aggregate->events)->toHaveCount(1)->each->toEqual(new TestEvent);

    });

    it('applies past events to itself', function () {

        $id = 'uuid';
        TestAggregate::retrieve($id)->doSomething()->save();

        $aggregate = TestAggregate::retrieve($id);

        expect($aggregate->events)->toHaveCount(1)->each->toEqual(new TestEvent);

    });

    it('saves recorded events', function () {

        $id = 'id';
        $aggregate = TestAggregate::retrieve($id);
        $aggregate->doSomething();

        $aggregate->save();

        assertDatabaseHas(Event::class, [
            'aggregate_id' => $id,
            'event' => TestEvent::class,
            'payload' => app(EventSerializer::class)->serialize(new TestEvent),
        ]);

    });

    it('does not resave already saved events', function () {

        $aggregate = TestAggregate::retrieve('ulid');
        $aggregate->doSomething()->save();
        assertDatabaseCount(Event::class, 1);

        $aggregate->save();

        assertDatabaseCount(Event::class, 1);

    });

    it('can have dependencies', function () {

        $aggregate = TestAggregateWithDependencies::retrieve(new TestId);

        expect($aggregate->dependency)->toBeInstanceOf(stdClass::class);

    });

    it('applies events to its segregates', function () {

        $aggregate = TestAggregateWithSegregates::retrieve(new TestId);

        $aggregate->doSomething();

        expect($aggregate->segregateAEvents())->toHaveCount(1)->each->toEqual(new TestEvent)
            ->and($aggregate->segregateBEvents())->toHaveCount(1)->each->toEqual(new TestEvent);

    });

})->covers(Aggregate::class);
