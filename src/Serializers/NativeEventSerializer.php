<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Serializers;

use Webmaesther\EventSourcing\Exceptions\CannotUnserializeException;

class NativeEventSerializer implements EventSerializer
{
    public function serialize(object $event): string
    {
        return serialize($event);
    }

    public function unserialize(string $payload): object
    {
        $object = unserialize($payload);

        if (! is_object($object)) {
            throw new CannotUnserializeException;
        }

        return $object;
    }
}
