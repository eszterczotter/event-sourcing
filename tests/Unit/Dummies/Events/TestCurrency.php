<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Events;

class TestCurrency
{
    public function __construct(
        public int $value,
        public string $currency,
    ) {}
}
