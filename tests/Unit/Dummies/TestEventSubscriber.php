<?php

declare(strict_types=1);

namespace Tests\Unit\Dummies;

use Illuminate\Contracts\Support\Arrayable;
use stdClass;
use Tests\Unit\Dummies\Events\TestEvent;
use Tests\Unit\Dummies\Events\TestEventInterfaceA;
use Tests\Unit\Dummies\Events\TestEventInterfaceB;

class TestEventSubscriber
{
    public static array $events = [];

    public function publicHandleTestEvent(TestEvent $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleTestEvent(TestEvent $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleTestEventVoid(TestEvent $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleTestEventVoid(TestEvent $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleTestEventReturn(TestEvent $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    protected function protectedHandleTestEventReturn(TestEvent $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    public function publicDoSomethingWithSomethingElse(stdClass $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedDoSomethingWithSomethingElse(stdClass $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicDoSomethingWithEventAndAParam(TestEvent $event, int $id): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedDoSomethingWithEventAndAParam(TestEvent $event, int $id): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleTestEventAndOtherEvent(TestEvent|StdClass $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleTestEventAndOtherEvent(TestEvent|StdClass $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleTestEventAndOtherEventVoid(TestEvent|StdClass $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleTestEventAndOtherEventVoid(TestEvent|StdClass $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleTestEventAndOtherEventReturn(TestEvent|StdClass $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    protected function protectedHandleTestEventAndOtherEventReturn(TestEvent|StdClass $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    public function publicHandleOtherArrayableEvent(StdClass|Arrayable $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleOtherArrayableEvent(StdClass|Arrayable $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleSpecificTestEvent(TestEventInterfaceA&TestEventInterfaceB $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleSpecificTestEvent(TestEventInterfaceA&TestEventInterfaceB $event)
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleSpecificTestEventVoid(TestEventInterfaceA&TestEventInterfaceB $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleSpecificTestEventVoid(TestEventInterfaceA&TestEventInterfaceB $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicHandleSpecificTestEventReturn(TestEventInterfaceA&TestEventInterfaceB $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    protected function protectedHandleSpecificTestEventReturn(TestEventInterfaceA&TestEventInterfaceB $event): bool
    {
        self::$events[__FUNCTION__] = $event;

        return true;
    }

    public function publicHandleArrayableTestEvent(TestEventInterfaceA&Arrayable $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedHandleArrayableTestEvent(TestEventInterfaceA&Arrayable $event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicDoSomethingWithoutType($event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    protected function protectedDoSomethingWithoutType($event): void
    {
        self::$events[__FUNCTION__] = $event;
    }

    public function publicDoSomething(): void
    {
        self::$events[__FUNCTION__] = null;
    }

    protected function protectedDoSomething(): void
    {
        self::$events[__FUNCTION__] = null;
    }
}
