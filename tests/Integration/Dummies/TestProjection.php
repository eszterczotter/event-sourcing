<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Webmaesther\EventSourcing\Projection\ProjectedBy;
use Webmaesther\EventSourcing\Projection\Projection;
use Webmaesther\EventSourcing\Projection\ReactedBy;

#[ObservedBy(TestProjectionObserver::class)]
#[ProjectedBy(TestProjector::class)]
#[ReactedBy(TestReactor::class)]
class TestProjection extends Projection
{
    protected $guarded = [];
}
