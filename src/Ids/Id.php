<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Ids;

use Webmaesther\EventSourcing\Exceptions\NonUlidStringException;

interface Id
{
    /**
     * @throws NonUlidStringException
     */
    public function __construct(?string $id = null);

    public function __toString(): string;
}
