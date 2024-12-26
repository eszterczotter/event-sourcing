<?php

use Tests\Integration\Dummies\TestAggregateWithSegregates;
use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Entities\Segregate;

describe(Segregate::class, function () {

    it('is abstract', function () {

        expect(Segregate::class)->toBeAbstract();

    });

    it('has only the specified public methods', function () {

        expect(Segregate::class)->not->toHavePublicMethodsBesides('__construct');

    });

    it('records events internally and fluently', function () {

        $aggregate = TestAggregateWithSegregates::retrieve('id');
        $segregate = $aggregate->segregate;

        $result = $segregate->doSomething();

        expect($result)->toBe($segregate);

    });

    it('records events in the aggregate', function () {

        $aggregate = TestAggregateWithSegregates::retrieve('uuid');
        $segregate = $aggregate->segregate;

        $segregate->doSomething();

        expect($aggregate->events)->toHaveCount(1)
            ->each->toEqual(new TestEvent);

    });

    it('holds a protected readonly reference to the aggregate root id', function () {

        $id = 'ulid';
        $aggregate = TestAggregateWithSegregates::retrieve($id);
        $segregate = $aggregate->segregate;

        expect($segregate)->not->toHavePublicProperty('id')
            ->and($segregate->getId())->toBe($id);
    });

})->covers(Segregate::class);
