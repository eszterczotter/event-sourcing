<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Entities\Segregate;

class TestSegregate extends Segregate
{
    public array $events = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function doSomething()
    {
        return $this->record(new TestEvent);
    }

    protected function handleTestEvent(TestEvent $event): void
    {
        $this->events[] = $event;
    }

    public function doSomethingWithEvent(TestEvent $event): void
    {
        $this->events[] = $event;
    }
}
