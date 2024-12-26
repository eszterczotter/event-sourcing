<?php

use Illuminate\Database\Eloquent\Model;
use Tests\Integration\Dummies\TestProjection;
use Webmaesther\EventSourcing\Exceptions\ReadonlyProjectionException;
use Webmaesther\EventSourcing\Projection\Projection;
use Webmaesther\EventSourcing\Projection\ProjectionObserver;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

describe(Projection::class, function () {

    it('is abstract', function () {

        expect(Projection::class)->tobeAbstract();

    });

    it('extends the eloquent model class', function () {

        expect(Projection::class)->toExtend(Model::class);

    });

    it('cannot be created directly', function () {

        expect(fn () => TestProjection::create())->toThrow(ReadonlyProjectionException::class);

    });

    it('can be created as a projection', function () {

        TestProjection::projection()->create(['id' => 100]);

        assertDatabaseHas(TestProjection::class, [
            'id' => 100,
        ]);

    });

    it('cannot be saved directly', function () {

        TestProjection::projection()->create();

        expect(fn () => TestProjection::first()->save())->toThrow(ReadonlyProjectionException::class);

    });

    it('can be saved as a projection', function () {

        TestProjection::projection()->create();

        TestProjection::first()->project()->fill(['id' => 200])->save();

        assertDatabaseHas(TestProjection::class, [
            'id' => 200,
        ]);

    });

    it('cannot be updated directly', function () {

        TestProjection::projection()->create();

        expect(fn () => TestProjection::first()->update(['id' => 200]))->toThrow(ReadonlyProjectionException::class);

    });

    it('can be updated as a projection', function () {

        TestProjection::projection()->create();

        TestProjection::first()->project()->update(['id' => 200]);

        assertDatabaseHas(TestProjection::class, [
            'id' => 200,
        ]);

    });

    it('cannot be deleted directly', function () {

        TestProjection::projection()->create();

        expect(fn () => TestProjection::first()->delete())->toThrow(ReadonlyProjectionException::class);

    });

    it('can be deleted as a projection', function () {

        TestProjection::projection()->create();
        assertDatabaseCount(TestProjection::class, 1);

        TestProjection::first()->project()->delete();

        assertDatabaseEmpty(TestProjection::class);

    });

    it('refreshes the projection', function () {

        $projection = TestProjection::projection()->create(['name' => 'Name']);
        $projection->name = 'New Name';
        expect($projection->readonly)->toBeFalse()
            ->and($projection->name)->toBe('New Name');

        $projection->refresh();

        expect($projection->name)->toBe('Name')
            ->and($projection->readonly)->toBeTrue()
            ->and(fn () => $projection->save())->toThrow(ReadonlyProjectionException::class);

    });

    it('returns a fresh projection', function () {

        $projection = TestProjection::projection()->create(['name' => 'Name']);
        $projection->name = 'New Name';
        expect($projection->readonly)->toBeFalse()
            ->and($projection->name)->toBe('New Name');

        $projection = $projection->fresh();

        expect($projection->name)->toBe('Name')
            ->and($projection->readonly)->toBeTrue()
            ->and(fn () => $projection->save())->toThrow(ReadonlyProjectionException::class);

    });

})->covers([Projection::class, ProjectionObserver::class, ReadonlyProjectionException::class]);
