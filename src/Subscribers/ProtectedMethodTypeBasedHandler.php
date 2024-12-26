<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Subscribers;

use ReflectionException;
use ReflectionMethod;

class ProtectedMethodTypeBasedHandler extends MethodTypeBasedHandler
{
    /**
     * @param  class-string|object  $subscriber
     *
     * @throws ReflectionException
     */
    public function __construct(string|object $subscriber)
    {
        parent::__construct($subscriber, ReflectionMethod::IS_PROTECTED);
    }
}
