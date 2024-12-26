<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Tests\Unit\Dummies\Events\TestEvent;

class TestReactor
{
    public function onTestEvent(TestEvent $event): void
    {
        TestProjection::first()->project()->update(['name' => 'Reacted Name']);
    }
}
