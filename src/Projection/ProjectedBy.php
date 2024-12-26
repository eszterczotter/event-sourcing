<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Projection;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ProjectedBy
{
    public function __construct(public readonly string $projector) {}
}
