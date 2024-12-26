<?php

declare(strict_types=1);

use Webmaesther\EventSourcing\EventSourcingServiceProvider;

describe(EventSourcingServiceProvider::class, function () {

    it('merges config', function () {

        expect(config('event-sourcing'))->toHaveKeys(['serializer']);

    });

    it('publishes assets', function () {

        expect(EventSourcingServiceProvider::$publishes[EventSourcingServiceProvider::class])->toBe([
            base_path('/src/../assets/config/') => base_path('config'),
            base_path('/src/../assets/database/migrations/') => base_path('database/migrations'),
        ]);

    });

    it('has a "config" publish groups', function () {

        expect(EventSourcingServiceProvider::$publishGroups['config'])->toBe([
            base_path('/src/../assets/config/') => base_path('config'),
        ]);

    });

    it('has a "migration" publish groups', function () {

        expect(EventSourcingServiceProvider::$publishGroups['migrations'])->toBe([
            base_path('/src/../assets/database/migrations/') => base_path('database/migrations'),
        ]);

    });

    it('has an "event-sourcing" publish group', function () {

        expect(EventSourcingServiceProvider::$publishGroups['event-sourcing'])->toBe([
            base_path('/src/../assets/config/') => base_path('config'),
            base_path('/src/../assets/database/migrations/') => base_path('database/migrations'),
        ]);

    });

})->covers(EventSourcingServiceProvider::class);
