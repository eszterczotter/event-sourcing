<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Entities\Aggregate;

class TestAggregateWithSegregates extends Aggregate
{
    public array $events = [];

    public readonly TestSegregate $segregate;

    private readonly TestSegregate $segregateA;

    private readonly TestSegregate $segregateB;

    public function __construct()
    {
        $this->segregate = new TestSegregate($this);
        $this->segregateA = new TestSegregate($this);
        $this->segregateB = new TestSegregate($this);
    }

    public function doSomething(): void
    {
        $this->record(new TestEvent);
    }

    public function segregateAEvents(): array
    {
        return $this->segregateA->events;
    }

    public function segregateBEvents(): array
    {
        return $this->segregateB->events;
    }

    protected function applyTestEvent(TestEvent $event): void
    {
        $this->events[] = $event;
    }
}
