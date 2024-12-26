<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use stdClass;
use Webmaesther\EventSourcing\Entities\Aggregate;

class TestAggregateWithDependencies extends Aggregate
{
    public function __construct(public readonly stdClass $dependency) {}
}
