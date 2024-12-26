<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Commands;

class SegregateMakeCommand extends MakeCommand
{
    protected $name = 'make:segregate';

    protected $description = 'Create a new segregate class';

    protected $type = 'Segregate';

    protected function stubFile(): string
    {
        return 'stubs/segregate.stub';
    }

    protected function getHint(): string
    {
        return 'Eg. CartItemSegregate';
    }
}
