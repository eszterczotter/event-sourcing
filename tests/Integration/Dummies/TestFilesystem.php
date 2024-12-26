<?php

declare(strict_types=1);

namespace Tests\Integration\Dummies;

use Illuminate\Filesystem\Filesystem;

class TestFilesystem extends Filesystem
{
    public $paths = [];

    public function put($path, $contents, $lock = false)
    {
        $this->paths[$path] = $contents;
    }

    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        //
    }
}
