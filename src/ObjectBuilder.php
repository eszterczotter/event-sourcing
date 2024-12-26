<?php

declare(strict_types = 1);

namespace Webmaesther\EventSourcing;

use ArgumentCountError;
use Error;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use TypeError;
use Webmaesther\EventSourcing\Exceptions\IncorrectDefinitionException;
use function app;

/**
 * @template TObject
 */
abstract class ObjectBuilder
{
    private int $count = 1;

    private array $state = [];

    /**
     * @var class-string<TObject>
     */
    abstract protected string $class {
        get;
    }

    public static function new(): static
    {
        return app(static::class);
    }

    abstract protected function definition(): array;

    /**
     * @return Collection<int, TObject>|TObject
     *
     * @throws IncorrectDefinitionException
     */
    public function build()
    {
        $objects = [];

        foreach (range(1, $this->count) as $i) {
            $objects[] = $this->buildOne();
        }

        if (count($objects) > 1) {
            return collect($objects);
        }

        return reset($objects);
    }

    /**
     * @return TObject
     *
     * @throws IncorrectDefinitionException
     */
    private function buildOne()
    {
        $definition = array_merge($this->definition(), $this->state);

        $definition = array_map(
            fn ($value) => $value instanceof ObjectBuilder ? $value->build() : $value,
            $definition,
        );

        try {
            return new $this->class(...$definition);
        } catch (ArgumentCountError | TypeError | Error $e) {
            throw new IncorrectDefinitionException(previous: $e);
        }
    }

    public function count(int $count): static
    {
        if ($count < 1) {
            throw new InvalidArgumentException;
        }

        $this->count = $count;

        return $this;
    }

    public function state(array $state): static
    {
        $this->state = $state;

        return $this;
    }
}