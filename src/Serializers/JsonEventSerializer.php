<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Serializers;

use JsonException;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use TypeError;
use Webmaesther\EventSourcing\Exceptions\CannotSerializeException;
use Webmaesther\EventSourcing\Exceptions\CannotUnserializeException;

class JsonEventSerializer implements EventSerializer
{
    public function serialize(object $event): string
    {
        try {
            $data = $this->getData($event);

            return json_encode($data, flags: JSON_THROW_ON_ERROR);

        } catch (JsonException $e) {

            throw new CannotSerializeException(previous: $e);
        }
    }

    private function getData(object $object): array
    {
        $data = [];
        $reflection = new ReflectionObject($object);
        foreach ($reflection->getProperties() as $property) {

            $value = $property->getValue($object);

            if (is_object($value)) {
                $value = $this->getData($value);
            }

            $data[$property->getName()] = $value;

        }

        return [
            '_class' => $object::class,
            '_data' => $data,
        ];
    }

    public function unserialize(string $payload): object
    {
        try {
            $data = json_decode($payload, associative: true, flags: JSON_THROW_ON_ERROR);

            return $this->getObject($data);

        } catch (JsonException|ReflectionException|TypeError $e) {
            throw new CannotUnserializeException(previous: $e);
        }
    }

    /**
     * @throws ReflectionException | CannotUnserializeException
     */
    public function getObject(array $payload): object
    {
        $payload = $this->validatePayload($payload);

        $reflection = new ReflectionClass($payload['_class']);
        $data = $payload['_data'];

        $object = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {

            $value = $data[$property->getName()] ?? null;

            if (is_array($value)
                && empty(array_diff(['_class', '_data'], array_keys($value)))
                && $property->getSettableType()?->getName() !== 'array'
            ) {

                $value = $this->getObject($value);

            }

            $property->setValue($object, $value);

        }

        return $object;
    }

    /**
     * @return array{_class:class-string,_data:array}
     *
     * @throws CannotUnserializeException
     */
    private function validatePayload(array $payload): array
    {
        if (! array_key_exists('_class', $payload)) {
            throw new CannotUnserializeException;
        }

        if (! array_key_exists('_data', $payload) || ! is_array($payload['_data'])) {
            throw new CannotUnserializeException;
        }

        return $payload;
    }
}
