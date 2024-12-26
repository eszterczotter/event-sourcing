<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Commands;

class ProjectionMakeCommand extends MakeCommand
{
    protected $name = 'make:projection';

    protected $description = 'Create a new projection class';

    protected $type = 'Projection';

    protected function stubFile(): string
    {
        return 'stubs/projection.stub';
    }

    protected function getHint(): string
    {
        return 'Eg. Product';
    }
}
