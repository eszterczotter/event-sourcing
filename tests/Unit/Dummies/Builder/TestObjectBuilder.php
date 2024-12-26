<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Builder;

use stdClass;
use Webmaesther\EventSourcing\ObjectBuilder;

/**
 * @extends  ObjectBuilder<TestObject>
 */
class TestObjectBuilder extends ObjectBuilder
{
    protected string $class = TestObject::class;

    public function __construct(public stdClass $dependency) {}

    protected function definition(): array
    {
        return [
            'message' => 'Hello world',
            'cost' => 50,
            'value' => TestValueBuilder::new(),
        ];
    }
}
