<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing;

use Illuminate\Support\Collection;
use Webmaesther\EventSourcing\Model\Event;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Serializers\EventSerializer;

class EventRepository
{
    public function __construct(protected EventSerializer $serializer) {}

    public function record(SourcedEvent $dto): void
    {
        $payload = $this->serializer->serialize($dto->event);

        Event::create([
            'aggregate_id' => $dto->aggregate_id,
            'event' => $dto->event::class,
            'payload' => $payload,
        ]);
    }

    public function past(string $id): Collection
    {
        return Event::where('aggregate_id', $id)
            ->get()
            ->map(fn (Event $event) => $this->serializer->unserialize($event->payload));
    }
}
