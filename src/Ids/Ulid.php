<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Ids;

use Illuminate\Support\Str;
use Webmaesther\EventSourcing\Exceptions\NonUlidStringException;

abstract class Ulid extends Uid
{
    final protected function generate(): string
    {
        return (string) Str::ulid();
    }

    /**
     * @throws NonUlidStringException
     */
    final protected function validate(string $id): void
    {
        if (Str::isUlid($id)) {
            return;
        }

        throw new NonUlidStringException;
    }
}
