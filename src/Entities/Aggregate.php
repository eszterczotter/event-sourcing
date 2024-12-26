<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Entities;

use ReflectionClass;
use ReflectionProperty;
use Webmaesther\EventSourcing\EventBus;
use Webmaesther\EventSourcing\EventRepository;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Subscribers\ProtectedMethodTypeBasedHandler;

abstract class Aggregate
{
    public readonly string $id;

    private array $records = [];

    private readonly array $segregates;

    public static function retrieve(string $id): static
    {
        $aggregate = app(static::class);
        $aggregate->id = $id;
        $aggregate->collectSegregates();
        $aggregate->reconstruct();

        return $aggregate;
    }

    public function record(object $event): static
    {
        $this->apply($event, $this);

        foreach ($this->segregates as $segregate) {
            $this->apply($event, $segregate);
        }

        $this->records[] = $event;

        return $this;
    }

    public function save(): void
    {
        $gun = app(EventBus::class);

        foreach ($this->records as $event) {
            $gun->dispatch(new SourcedEvent($event, $this->id));
        }

        $this->records = [];
    }

    private function collectSegregates(): void
    {
        $this->segregates = array_map(
            fn (ReflectionProperty $property) => $property->getValue($this),
            array_filter(
                new ReflectionClass($this)->getProperties(),
                fn (ReflectionProperty $property) => $property->getValue($this) instanceof Segregate,
            ),
        );
    }

    private function reconstruct(): void
    {
        $repository = app(EventRepository::class);

        foreach ($repository->past($this->id) as $event) {
            $this->apply($event, $this);
        }
    }

    private function apply(object $event, object $subscriber): void
    {
        new ProtectedMethodTypeBasedHandler($subscriber)($event);
    }
}
