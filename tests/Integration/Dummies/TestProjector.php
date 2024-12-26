<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Tests\Unit\Dummies\Events\TestEvent;

class TestProjector
{
    public function onTestEvent(TestEvent $event): void
    {
        TestProjection::projection()->create(['name' => 'Projected Name']);
    }
}
