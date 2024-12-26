<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Exceptions;

use RuntimeException;
use Webmaesther\EventSourcing\Projection\Projection;

class ReadonlyProjectionException extends RuntimeException
{
    public function __construct(public readonly Projection $projection)
    {
        parent::__construct(sprintf('The projection %s is readonly.', $projection::class), 500);
    }
}
