<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Builder;

use Webmaesther\EventSourcing\ObjectBuilder;

class UnnecessaryArgumentTestObjectBuilder extends ObjectBuilder
{
    protected string $class = TestObject::class;

    protected function definition(): array
    {
        return [
            'message' => 'Hello world',
            'cost' => 50,
            'value' => TestValueBuilder::new(),
            'something' => 'unnecessary',
        ];
    }
}
