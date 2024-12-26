<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing;

use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Projection\Projectionist;

class EventBus
{
    public function __construct(
        protected readonly EventRepository $repository,
        protected readonly Projectionist $projectionist,
    ) {}

    public function dispatch(SourcedEvent $sourced)
    {
        $this->repository->record($sourced);
        $this->projectionist->play($sourced);
    }
}
