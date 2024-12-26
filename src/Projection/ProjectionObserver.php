<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Projection;

use Webmaesther\EventSourcing\Exceptions\ReadonlyProjectionException;

class ProjectionObserver
{
    public function saving(Projection $projection): void
    {
        $this->protect($projection);
    }

    public function deleting(Projection $projection): void
    {
        $this->protect($projection);
    }

    protected function protect(Projection $projection): void
    {
        if ($projection->readonly) {
            throw new ReadonlyProjectionException($projection);
        }
    }
}
