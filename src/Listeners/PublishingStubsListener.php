<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Listeners;

use Illuminate\Foundation\Events\PublishingStubs;

use function Webmaesther\EventSourcing\asset_path;

class PublishingStubsListener
{
    public function __invoke(PublishingStubs $event): void
    {
        foreach (glob(asset_path('stubs/*.stub')) as $stub) {
            $event->add($stub, (string) str($stub)->afterLast('/'));
        }
    }
}
