<?php

declare(strict_types=1);

use Tests\Unit\Dummies\Events\TestEvent;
use Tests\Unit\Dummies\TestEventSubscriber;
use Webmaesther\EventSourcing\Subscribers\EventHandler;
use Webmaesther\EventSourcing\Subscribers\MethodTypeBasedHandler;
use Webmaesther\EventSourcing\Subscribers\ProtectedMethodTypeBasedHandler;

describe(ProtectedMethodTypeBasedHandler::class, function () {

    it(sprintf('implements %s interface', EventHandler::class), function () {

        expect(ProtectedMethodTypeBasedHandler::class)->toOnlyImplement(EventHandler::class);
    });

    it('handles events with protected methods based on argument types', function () {

        $event = new TestEvent;

        new ProtectedMethodTypeBasedHandler(TestEventSubscriber::class)($event);

        expect(TestEventSubscriber::$events)
            ->tohaveCount(6)
            ->toHaveKeys([
                'protectedHandleTestEvent',
                'protectedHandleTestEventVoid',
                'protectedHandleTestEventAndOtherEvent',
                'protectedHandleTestEventAndOtherEventVoid',
                'protectedHandleSpecificTestEvent',
                'protectedHandleSpecificTestEventVoid',
            ]);

        TestEventSubscriber::$events = [];
    });

})->covers([MethodTypeBasedHandler::class, ProtectedMethodTypeBasedHandler::class]);
