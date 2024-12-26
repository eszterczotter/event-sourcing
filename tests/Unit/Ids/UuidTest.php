<?php

declare(strict_types=1);

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Str;
use Tests\Unit\Dummies\TestUuid;
use Webmaesther\EventSourcing\Exceptions\NonUuidStringException;
use Webmaesther\EventSourcing\Ids\Id;
use Webmaesther\EventSourcing\Ids\IdCast;
use Webmaesther\EventSourcing\Ids\Uid;
use Webmaesther\EventSourcing\Ids\Uuid;

describe(Uuid::class, function () {

    it(sprintf('implements the %s interface', Id::class), function () {

        expect(Uuid::class)
            ->toBeAbstract()
            ->toImplement(Id::class)
            ->toHaveFinalMethods(['__construct', '__toString']);

    });

    it('can not reconstruct from a non uuid id', function () {

        expect(fn () => new class((string) Str::ulid()) extends Uuid {})
            ->toThrow(NonUuidStringException::class);

    });

    it('reconstructs from an existing uuid', function (string $id) {

        expect((string) new class($id) extends Uuid {})->toBe($id);

    })->with([(string) Str::uuid(), (string) Str::uuid()]);

    it('is stringable', function () {

        expect([
            (string) new class extends Uuid {},
            (string) new class(null) extends Uuid {},
            (string) new class((string) Str::uuid()) extends Uuid {},
        ])->each->toBeString();

    });

    it('generates a non empty new id', function () {

        expect([
            (string) new class extends Uuid {},
            (string) new class(null) extends Uuid {},
        ])->each->not->toBeEmpty();

    });

    it('generates a new ulid', function () {

        expect((string) new class extends Uuid {})->toBeUuid();

    });

    it(sprintf('implements %s interface', Castable::class), function () {

        expect(Uuid::class)->toImplement(Castable::class);

    });

    it(sprintf('casts using the %s', IdCast::class), function () {

        expect(TestUuid::castUsing([]))->toEqual(new IdCast(TestUuid::class));

    });

})->covers([Uuid::class, Uid::class]);
