<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Model;

final readonly class SourcedEvent
{
    public function __construct(
        public object $event,
        public string $aggregate_id,
    ) {}
}
