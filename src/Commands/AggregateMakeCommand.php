<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Commands;

class AggregateMakeCommand extends MakeCommand
{
    protected $name = 'make:aggregate';

    protected $description = 'Create a new aggregate class';

    protected $type = 'Aggregate';

    protected function stubFile(): string
    {
        return 'stubs/aggregate.stub';
    }

    protected function getHint(): string
    {
        return 'Eg. CartAggregate';
    }
}
