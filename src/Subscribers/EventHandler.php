<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Subscribers;

interface EventHandler
{
    public function __invoke(object $event): void;
}
