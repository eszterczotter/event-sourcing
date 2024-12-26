<?php

declare(strict_types = 1);

namespace Webmaesther\EventSourcing\Ids;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Webmaesther\EventSourcing\Exceptions\NonUidStringException;

abstract class Uid implements Id, Castable
{
    protected private(set) readonly string $id;

    /**
     * @throws NonUidStringException
     */
    final public function __construct(?string $id = null)
    {
        $id ??= $this->generate();

        $this->validate($id);

        $this->id = $id;
    }

    final public function __toString(): string
    {
        return $this->id;
    }

    abstract protected function generate(): string;

    /**
     * @throws NonUidStringException
     */
    abstract protected function validate(string $id): void;

    public static function castUsing(array $arguments)
    {
        return new IdCast(static::class);
    }
}