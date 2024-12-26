<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Builder;

use Webmaesther\EventSourcing\ObjectBuilder;

class MissingArgumentTestObjectBuilder extends ObjectBuilder
{
    protected string $class = TestObject::class;

    protected function definition(): array
    {
        return [
            'message' => 'This is not enough',
            'value' => TestValueBuilder::new(),
        ];
    }
}
