<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Subscribers;

use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;

use function app;

abstract class MethodTypeBasedHandler implements EventHandler
{
    private ReflectionClass $reflection;

    /**
     * @param  class-string|object  $subscriber
     *
     * @throws ReflectionException
     */
    public function __construct(private string|object $subscriber, private int $filter)
    {
        $this->reflection = new ReflectionClass($subscriber);
    }

    /**
     * @throws ReflectionException
     */
    public function __invoke(object $event): void
    {
        $handlers = $this->handlers($event);

        foreach ($handlers as $handler) {
            $object = is_object($this->subscriber) ? $this->subscriber : app($this->subscriber);
            $handler->invoke($object, $event);
        }
    }

    /**
     * @return ReflectionMethod[]
     */
    private function handlers(object $event): array
    {
        $handlers = [];

        foreach ($this->getMethods() as $method) {

            if ($this->isHandlerForEvent($event, $method)) {
                $handlers[] = $method;
            }

        }

        return $handlers;
    }

    private function getSingleType(ReflectionMethod $method): ?ReflectionType
    {
        $parameters = $method->getParameters();

        if (count($parameters) > 1) {
            return null;
        }

        $parameter = reset($parameters);

        if (! $parameter) {
            return null;
        }

        return $parameter->getType();
    }

    private function fulfillsType(object $event, ReflectionType $type): bool
    {
        return match (get_class($type)) {
            ReflectionNamedType::class => $this->isOfType($event, $type),
            ReflectionUnionType::class => array_any($type->getTypes(), fn ($t) => $this->isOfType($event, $t)),
            ReflectionIntersectionType::class => array_all($type->getTypes(), fn ($t) => $this->isOfType($event, $t)),
        };
    }

    private function isOfType(object $event, ReflectionNamedType $type): bool
    {
        return is_a($event, $type->getName());
    }

    private function isHandlerForEvent(object $event, ReflectionMethod $method): bool
    {
        if ($method->getReturnType() !== null && $method->getReturnType()->getName() !== 'void') {
            return false;
        }

        $type = $this->getSingleType($method);

        if (! $type) {
            return false;
        }

        return $this->fulfillsType($event, $type);
    }

    /**
     * @return ReflectionMethod[]
     */
    private function getMethods(): array
    {
        return $this->reflection->getMethods($this->filter);
    }
}
