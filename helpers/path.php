<?php

namespace Webmaesther\EventSourcing;

if (! function_exists('package_path')) {
    function package_path(string $path): string
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.$path;
    }
}

if (! function_exists('asset_path')) {
    function asset_path(string $path): string
    {
        return package_path('assets'.DIRECTORY_SEPARATOR.$path);
    }
}
