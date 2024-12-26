<?php

declare(strict_types=1);

use Webmaesther\EventSourcing\Exceptions\NonUidStringException;
use Webmaesther\EventSourcing\Exceptions\NonUlidStringException;
use Webmaesther\EventSourcing\Exceptions\NonUuidStringException;

$exceptions = [
    NonUuidStringException::class,
    NonUlidStringException::class,
];

dataset('exceptions', $exceptions);

describe(NonUidStringException::class, function () {

    it(
        sprintf('extends the %s exception', NonUidStringException::class),

        /** @param class-string<NonUidStringException> $exception */
        function (string $exception) {

            expect($exception)->toExtend(NonUidStringException::class);

        })->with('exceptions');

})->covers($exceptions);
