<?php

declare(strict_types=1);

use Webmaesther\EventSourcing\Subscribers\EventHandler;
use Webmaesther\EventSourcing\Subscribers\MethodTypeBasedHandler;

describe(MethodTypeBasedHandler::class, function () {

    it('is abstract', function () {

        expect(MethodTypeBasedHandler::class)
            ->tobeAbstract()
            ->toOnlyImplement(EventHandler::class);

    });

})->covers([MethodTypeBasedHandler::class]);
