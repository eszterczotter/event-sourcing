<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Builder;

use Tests\Unit\Dummies\TestValue;

readonly class TestObject
{
    public function __construct(
        public string $message,
        public int $cost,
        TestValue $value,
    ) {}
}
