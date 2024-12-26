<?php

declare(strict_types = 1);

namespace Webmaesther\EventSourcing\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use function Webmaesther\EventSourcing\asset_path;
use function Webmaesther\EventSourcing\composer;

abstract class MakeCommand extends GeneratorCommand
{
    protected const string PHP_EXTENSION = '.php';

    protected string $rootPath {
        get  => $this->rootPath ??= $this->laravel->basePath($this->namespacePathMap[$this->rootNamespace()]);
    }

    protected string $rootNamespace {
        get => $this->rootNamespace
            ??= array_find($this->namespaces, fn($n) => str($n)->startsWith('Domain'))
            ?? array_find($this->namespaces, fn($n) => str($n)->startsWith('App'))
            ?? array_find($this->namespaces, fn() => true);
    }

    protected array $namespaces {
        get => $this->namespaces ??= array_keys($this->namespacePathMap);
    }

    protected array $namespacePathMap {
        get => $this->namespacePathMap ??= composer('autoload.psr-4');
    }

    protected function resolveStubPath($stub): string
    {
        $customPath = $this->laravel->basePath($stub);

        return file_exists($customPath) ? $customPath : asset_path($stub);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => [ $this->getNamePrompt(), $this->getHint() ],
        ];
    }

    protected function rootNamespace(): string
    {
        return $this->rootNamespace;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace;
    }

    protected function getNamePrompt(): string
    {
        return 'What should the '.strtolower($this->type).' be named?';
    }

    protected function getPath($name): string
    {
        $path = Str::replaceFirst($this->rootNamespace(), $this->rootPath, $name);

        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

        return $path . static::PHP_EXTENSION;
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath($this->stubFile());
    }

    abstract protected function stubFile(): string;

    abstract protected function getHint(): string;

}