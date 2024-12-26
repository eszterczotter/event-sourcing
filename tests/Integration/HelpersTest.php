<?php

declare(strict_types=1);

use function Webmaesther\EventSourcing\asset_path;
use function Webmaesther\EventSourcing\composer;
use function Webmaesther\EventSourcing\package_path;

describe('Helper functions', function () {

    test('package_path is relative to the package root folder', function () {

        expect(package_path('hello/world'))
            ->toBe(dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'hello/world');

    });

    test('asset_path is relative to the assets folder in package root', function () {

        expect(asset_path('my/path'))
            ->toBe(dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'my/path');

    });

    test('composer loads composer.json', function () {

        expect(composer('name'))->toBe('webmaesther/event-sourcing')
            ->and(composer('authors.0.email'))->toBe('eszter.czotter@gmail.com')
            ->and(composer('non-existing-key', 42))->toBe(42);

    });
});
