<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Ids;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TId of Id
 */
class IdCast implements CastsAttributes
{
    /**
     * @param  class-string<TId>  $class
     */
    public function __construct(private string $class) {}

    /**
     * @param  string  $value
     * @return TId
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new $this->class($value);
    }

    /**
     * @param  TId  $value
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return (string) $value;
    }
}
