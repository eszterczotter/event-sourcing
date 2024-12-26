<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies\Events;

class NestedTestEvent
{
    public $test;

    public function __construct(
        public string $message,
        public int $code,
        public float $time,
        public array $data,
        public TestCurrency $nested,
        public ?TestCurrency $nullable,
        public ?TestCurrency $null,
        public $mixed,
    ) {
        $this->test = 'something';
    }
}
