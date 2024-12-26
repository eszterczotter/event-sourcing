<?php

declare(strict_types = 1);

namespace Webmaesther\EventSourcing\Projection;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ProjectionObserver::class)]
abstract class Projection extends Model
{
    private(set) bool $readonly = true;

    public static function projection(): static
    {
        return new static()->project();
    }

    public function project(): static
    {
        $projection = clone $this;

        $projection->readonly = false;

        return $projection;
    }

    public function newInstance($attributes = [], $exists = false): static
    {
        $instance = parent::newInstance($attributes, $exists);

        $instance->readonly = $this->readonly;

        return $instance;
    }

    public function refresh(): static
    {
        parent::refresh();

        $this->readonly = true;

        return $this;
    }

    public function fresh($with = []): static
    {
        $projection = parent::fresh($with);

        $projection->readonly = true;

        return $projection;
    }
}
