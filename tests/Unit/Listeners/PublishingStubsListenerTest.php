<?php

declare(strict_types=1);

use Illuminate\Foundation\Events\PublishingStubs;
use Webmaesther\EventSourcing\Listeners\PublishingStubsListener;

use function Webmaesther\EventSourcing\asset_path;

describe(PublishingStubsListener::class, function () {

    it('adds our stubs', function () {

        $event = new PublishingStubs([
            'foo' => 'bar',
        ]);

        (new PublishingStubsListener)($event);

        expect($event->stubs)->toBe([
            'foo' => 'bar',
            asset_path('stubs/aggregate.stub') => 'aggregate.stub',
            asset_path('stubs/builder.stub') => 'builder.stub',
            asset_path('stubs/projection.stub') => 'projection.stub',
            asset_path('stubs/projector.stub') => 'projector.stub',
            asset_path('stubs/segregate.stub') => 'segregate.stub',
        ]);

    });
});
