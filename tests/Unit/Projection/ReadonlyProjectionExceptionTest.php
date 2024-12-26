<?php

use Tests\Integration\Dummies\TestProjection;
use Webmaesther\EventSourcing\Exceptions\ReadonlyProjectionException;

describe(ReadonlyProjectionException::class, function () {

    it("'s message is correct", function () {

        $exception = new ReadonlyProjectionException(new TestProjection);

        expect($exception->getMessage())->toBe("The projection Tests\Integration\Dummies\TestProjection is readonly.");

    });

    it("'s code is correct", function () {

        $exception = new ReadonlyProjectionException(new TestProjection);

        expect($exception->getCode())->toBe(500);

    });

    it('holds a readonly reference to the projection', function () {

        $projection = new TestProjection;
        $exception = new ReadonlyProjectionException($projection);

        expect($exception->projection)->toBe($projection)
            ->and(fn () => $exception->projection = new TestProjection)
            ->toThrow(Error::class);
    });

})->covers(ReadonlyProjectionException::class);
