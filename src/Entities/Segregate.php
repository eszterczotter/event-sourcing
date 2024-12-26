<?php

declare(strict_types = 1);

namespace Webmaesther\EventSourcing\Entities;

use Webmaesther\EventSourcing\Ids\Id;

abstract class Segregate
{
    protected string $id {
        get => $this->aggregate->id;
    }

    public function __construct(private readonly Aggregate $aggregate) {}

    protected function record(object $event): static
    {
        $this->aggregate->record($event);

        return $this;
    }

}
