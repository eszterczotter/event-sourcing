<?php

declare(strict_types=1);

use Tests\Unit\Dummies\Events\TestEvent;
use Tests\Unit\Dummies\TestEventSubscriber;
use Webmaesther\EventSourcing\Subscribers\EventHandler;
use Webmaesther\EventSourcing\Subscribers\MethodTypeBasedHandler;
use Webmaesther\EventSourcing\Subscribers\PublicMethodTypeBasedHandler;

describe(PublicMethodTypeBasedHandler::class, function () {

    it(sprintf('implements %s interface', EventHandler::class), function () {

        expect(PublicMethodTypeBasedHandler::class)->toOnlyImplement(EventHandler::class)
            ->and(PublicMethodTypeBasedHandler::class)->not->toHavePublicMethodsBesides(['__construct', '__invoke']);
    });

    it('handles events with public methods based on argument types', function () {

        $event = new TestEvent;

        new PublicMethodTypeBasedHandler(TestEventSubscriber::class)($event);

        expect(TestEventSubscriber::$events)
            ->tohaveCount(6)
            ->toHaveKeys([
                'publicHandleTestEvent',
                'publicHandleTestEventVoid',
                'publicHandleTestEventAndOtherEvent',
                'publicHandleTestEventAndOtherEventVoid',
                'publicHandleSpecificTestEvent',
                'publicHandleSpecificTestEventVoid',
            ]);

        TestEventSubscriber::$events = [];
    });

})->covers([MethodTypeBasedHandler::class, PublicMethodTypeBasedHandler::class]);
