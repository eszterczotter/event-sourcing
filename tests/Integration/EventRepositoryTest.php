<?php

use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\EventRepository;
use Webmaesther\EventSourcing\Model\Event;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Serializers\EventSerializer;

use function Pest\Laravel\assertDatabaseHas;

describe(EventRepository::class, function () {

    it('records events', function () {

        $repository = app(EventRepository::class);
        $event = new TestEvent;

        $repository->record(new SourcedEvent($event, 'root-id'));

        assertDatabaseHas(Event::class, [
            'aggregate_id' => 'root-id',
            'event' => TestEvent::class,
            'payload' => app(EventSerializer::class)->serialize($event),
        ]);

    });

    it('gets past events by aggregate id', function () {

        $repository = app(EventRepository::class);
        $repository->record(new SourcedEvent(new TestEvent, 'id'));
        $repository->record(new SourcedEvent(new TestEvent, 'id'));

        $events = $repository->past('id');

        expect($events)->toHaveCount(2)->each->toEqual(new TestEvent);

    });

})->covers([EventRepository::class, Event::class]);
