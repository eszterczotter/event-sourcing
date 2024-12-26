<?php

use Tests\Integration\Dummies\TestProjection;
use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\EventBus;
use Webmaesther\EventSourcing\EventSourcingServiceProvider;
use Webmaesther\EventSourcing\Model\Event;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Projection\Projectionist;
use Webmaesther\EventSourcing\Serializers\EventSerializer;

use function Pest\Laravel\assertDatabaseHas;

describe(EventBus::class, function () {

    it('is a singleton', function () {

        expect(app(EventBus::class))->toBe(app(EventBus::class));

    });

    it('dispatches events to projectors and reactors', function () {

        app(Projectionist::class)
            ->control(TestProjection::class);

        app(EventBus::class)
            ->dispatch(new SourcedEvent($event = new TestEvent, 'uuid'));

        assertDatabaseHas(Event::class, [
            'aggregate_id' => 'uuid',
            'event' => $event::class,
            'payload' => app(EventSerializer::class)->serialize($event),
        ]);
        assertDatabaseHas(TestProjection::class, [
            'name' => 'Reacted Name',
        ]);

    });

})->covers([EventBus::class, EventSourcingServiceProvider::class]);
