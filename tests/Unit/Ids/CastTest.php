<?php

declare(strict_types=1);

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;
use Tests\Integration\Dummies\TestId;
use Webmaesther\EventSourcing\Ids\IdCast;
use Webmaesther\EventSourcing\Model\Event;

describe(IdCast::class, function () {

    it(sprintf('it implements %s interface', CastsAttributes::class), function () {

        expect(IdCast::class)->toOnlyImplement(CastsAttributes::class);

    });

    it('gets an id', function () {

        $id = (string) Str::uuid();
        $cast = new IdCast(TestId::class);

        $value = $cast->get(new Event, 'id', $id, compact('id'));

        expect($value)->toBeInstanceOf(TestId::class);

    });

    it('sets an id', function () {

        $id = new TestId;
        $cast = new IdCast(TestId::class);

        $value = $cast->set(new Event, 'id', $id, compact('id'));

        expect($value)->toBe((string) $id);

    });

})->covers(IdCast::class);
