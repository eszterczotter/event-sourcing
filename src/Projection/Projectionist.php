<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Projection;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Subscribers\PublicMethodTypeBasedHandler;

class Projectionist
{
    /** @var class-string<Projection>[] */
    private array $projections = [];

    /** @var PublicMethodTypeBasedHandler[] */
    private array $projectors = [];

    /** @var PublicMethodTypeBasedHandler[] */
    private array $reactors = [];

    /**
     * @param  class-string<Projection>  $projection
     *
     * @throws ReflectionException
     */
    public function control(string $projection): void
    {
        $this->projections[] = $projection;

        $reflection = new ReflectionClass($projection);

        foreach ($reflection->getAttributes(ProjectedBy::class) as $attribute) {
            /** @var ProjectedBy $projectedBy */
            $projectedBy = $attribute->newInstance();
            $this->projectors[] = new PublicMethodTypeBasedHandler($projectedBy->projector);
        }

        foreach ($reflection->getAttributes(ReactedBy::class) as $attribute) {
            /** @var ReactedBy $reactedBy */
            $reactedBy = $attribute->newInstance();
            $this->reactors[] = new PublicMethodTypeBasedHandler($reactedBy->reactor);
        }
    }

    public function play(SourcedEvent $sourced): void
    {
        $this->project($sourced);
        $this->react($sourced);
    }

    public function replay(SourcedEvent $sourced): void
    {
        $this->project($sourced);
    }

    /**
     * @param  ?class-string<Projection>  $projection
     */
    public function rewind(?string $projection = null): void
    {
        if (is_subclass_of($projection, Projection::class)) {
            $projection::projection()->truncate();

            return;
        }

        if ($projection !== null) {
            throw new InvalidArgumentException;
        }

        foreach ($this->projections as $projection) {
            $projection::projection()->truncate();
        }
    }

    private function project(SourcedEvent $sourced): void
    {
        foreach ($this->projectors as $projector) {
            $projector($sourced->event);
        }
    }

    private function react(SourcedEvent $sourced): void
    {
        foreach ($this->reactors as $reactor) {
            $reactor($sourced->event);
        }
    }
}
