<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies\Events;

class TestEventWithPrivateTypedProperty
{
    public function __construct(private string $message) {}
}
