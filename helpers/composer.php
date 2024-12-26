<?php

namespace Webmaesther\EventSourcing;

if (! function_exists('composer')) {
    function composer(string $key, mixed $default = null): mixed
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        return data_get($composer, $key, $default);
    }
}
