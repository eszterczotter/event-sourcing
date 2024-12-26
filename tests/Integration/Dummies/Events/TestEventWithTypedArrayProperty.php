<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies\Events;

class TestEventWithTypedArrayProperty
{
    public function __construct(public array $data) {}
}
