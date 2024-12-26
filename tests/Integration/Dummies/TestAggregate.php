<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Entities\Aggregate;

class TestAggregate extends Aggregate
{
    public array $events = [];

    public function doSomething(): self
    {
        return $this->record(new TestEvent);
    }

    protected function onTestEvent(TestEvent $event): void
    {
        $this->events[] = $event;
    }

    public function publicTestEventHandler(TestEvent $event): void
    {
        $this->events[] = $event;
    }
}
