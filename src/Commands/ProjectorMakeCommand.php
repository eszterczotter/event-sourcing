<?php

declare(strict_types=1);

namespace Webmaesther\EventSourcing\Commands;

class ProjectorMakeCommand extends MakeCommand
{
    protected $name = 'make:projector';

    protected $description = 'Create a new projector class';

    protected $type = 'Projector';

    protected function stubFile(): string
    {
        return 'stubs/projector.stub';
    }

    protected function getHint(): string
    {
        return 'Eg. ProductProjector';
    }
}
