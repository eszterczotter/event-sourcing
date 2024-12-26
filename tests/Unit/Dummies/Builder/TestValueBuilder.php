<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Builder;

use Tests\Unit\Dummies\TestValue;
use Webmaesther\EventSourcing\ObjectBuilder;

/**
 * @extends ObjectBuilder<TestValue>
 */
class TestValueBuilder extends ObjectBuilder
{
    protected string $class = TestValue::class;

    protected function definition(): array
    {
        return [];
    }
}
