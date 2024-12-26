<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Ids;

use Illuminate\Support\Str;
use Webmaesther\EventSourcing\Exceptions\NonUuidStringException;

abstract class Uuid extends Uid
{
    final protected function generate(): string
    {
        return (string) Str::uuid();
    }

    /**
     * @throws NonUuidStringException
     */
    final protected function validate(string $id): void
    {
        if (Str::isUuid($id)) {
            return;
        }

        throw new NonUuidStringException;
    }
}
