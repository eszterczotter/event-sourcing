<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Serializers;

use Webmaesther\EventSourcing\Exceptions\CannotSerializeException;
use Webmaesther\EventSourcing\Exceptions\CannotUnserializeException;

interface EventSerializer
{
    /**
     * @throws CannotSerializeException
     */
    public function serialize(object $event): string;

    /**
     * @throws CannotUnserializeException
     */
    public function unserialize(string $payload): object;
}
