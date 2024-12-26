<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Commands;

use function array_find;
use function str;

class BuilderMakeCommand extends MakeCommand
{
    protected $name = 'make:builder';

    protected $description = 'Create a new builder class';

    protected $type = 'Builder';

    protected string $rootNamespace {
        get => $this->rootNamespace
            ??= array_find($this->namespaces, fn($n) => str($n)->startsWith('Database\\Builder'))
            ?? array_find($this->namespaces, fn() => true);
    }

    protected function stubFile(): string
    {
        return 'stubs/builder.stub';
    }

    protected function getHint(): string
    {
        return 'Eg. OrderPurchasedBuilder';
    }
}
