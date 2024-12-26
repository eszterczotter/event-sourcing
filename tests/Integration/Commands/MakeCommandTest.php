<?php

declare(strict_types=1);

namespace Tests\Integration\Commands;

use Illuminate\Filesystem\Filesystem;
use Tests\Integration\Dummies\TestFilesystem;
use Webmaesther\EventSourcing\Commands\AggregateMakeCommand;
use Webmaesther\EventSourcing\Commands\BuilderMakeCommand;
use Webmaesther\EventSourcing\Commands\MakeCommand;
use Webmaesther\EventSourcing\Commands\ProjectionMakeCommand;
use Webmaesther\EventSourcing\Commands\ProjectorMakeCommand;
use Webmaesther\EventSourcing\Commands\SegregateMakeCommand;
use Webmaesther\EventSourcing\EventSourcingServiceProvider;

use function base_path;
use function expect;
use function it;
use function Pest\Laravel\artisan;
use function Pest\Laravel\instance;
use function sprintf;
use function str;

describe(MakeCommand::class, function () {

    it('generates a new class in the main namespace', function (string $command, string $type) {

        instance(Filesystem::class, $filesystem = new TestFilesystem);
        $name = 'Test/Example';
        $file = "src/{$name}.php";
        $command = artisan($command)
            ->expectsQuestion("What should the {$type} be named?", $name)
            ->expectsOutputToContain(sprintf("%s [$file] created successfully.", str($type)->title()));

        $command->execute();

        expect($filesystem->paths)->toHaveKey(base_path($file));

    })->with([
        'make:aggregate' => ['make:aggregate', 'aggregate'],
        'make:builder' => ['make:builder', 'builder'],
        'make:projection' => ['make:projection', 'projection'],
        'make:projector' => ['make:projector', 'projector'],
        'make:segregate' => ['make:segregate', 'segregate'],
    ]);

})->covers([
    MakeCommand::class,
    EventSourcingServiceProvider::class,

    /** Commands */
    AggregateMakeCommand::class,
    BuilderMakeCommand::class,
    ProjectionMakeCommand::class,
    ProjectorMakeCommand::class,
    SegregateMakeCommand::class,
]);
