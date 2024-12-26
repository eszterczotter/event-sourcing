<?php

declare(strict_types=1);

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Support\Str;
use Tests\Unit\Dummies\TestUlid;
use Webmaesther\EventSourcing\Exceptions\NonUlidStringException;
use Webmaesther\EventSourcing\Ids\Id;
use Webmaesther\EventSourcing\Ids\IdCast;
use Webmaesther\EventSourcing\Ids\Uid;
use Webmaesther\EventSourcing\Ids\Ulid;

describe(Ulid::class, function () {

    it(sprintf('implements the %s interface', Id::class), function () {

        expect(Ulid::class)
            ->toBeAbstract()
            ->toImplement(Id::class)
            ->toHaveFinalMethods(['__construct', '__toString']);

    });

    it('can not reconstruct from a non ulid id', function () {

        expect(fn () => new class((string) Str::uuid()) extends Ulid {})
            ->toThrow(NonUlidStringException::class);

    });

    it('reconstructs from an existing ulid', function (string $id) {

        expect((string) new class($id) extends Ulid {})->toBe($id);

    })->with([(string) Str::ulid(), (string) Str::ulid()]);

    it('is stringable', function () {

        expect([
            (string) new class extends Ulid {},
            (string) new class(null) extends Ulid {},
            (string) new class((string) Str::ulid()) extends Ulid {},
        ])->each->toBeString();

    });

    it('generates a non empty new id', function () {

        expect([
            (string) new class extends Ulid {},
            (string) new class(null) extends Ulid {},
        ])->each->not->toBeEmpty();

    });

    it('generates a new ulid', function () {

        expect((string) new class extends Ulid {})->toBeUlid();

    });

    it(sprintf('implements %s interface', Castable::class), function () {

        expect(Ulid::class)->toImplement(Castable::class);

    });

    it(sprintf('casts using the %s', IdCast::class), function () {

        expect(TestUlid::castUsing([]))->toEqual(new IdCast(TestUlid::class));

    });

})->covers([Ulid::class, Uid::class]);
