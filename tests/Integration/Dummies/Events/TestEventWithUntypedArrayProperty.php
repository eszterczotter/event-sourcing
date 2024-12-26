<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies\Events;

class TestEventWithUntypedArrayProperty
{
    public function __construct(public $data) {}
}
