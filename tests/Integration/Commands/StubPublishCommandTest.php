<?php

declare(strict_types=1);

use Illuminate\Foundation\Events\PublishingStubs;
use Webmaesther\EventSourcing\EventSourcingServiceProvider;
use Webmaesther\EventSourcing\Listeners\PublishingStubsListener;

describe('stub:publish', function () {

    test(sprintf('we are listening for the %s event', PublishingStubs::class), function () {

        Event::fake()->assertListening(
            PublishingStubs::class,
            PublishingStubsListener::class,
        );

    });
})->covers([PublishingStubsListener::class, EventSourcingServiceProvider::class]);
