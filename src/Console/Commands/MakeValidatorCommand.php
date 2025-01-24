<?php

namespace YepBro\EloquentValidator\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use YepBro\EloquentValidator\Constants;

class MakeValidatorCommand extends GeneratorCommand
{
    protected $name = 'make:validator';

    protected $description = 'Create a new validator class';

    protected function getStub(): string
    {
        return __DIR__ . '/../../../stubs/validator.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return config(Constants::KEY . '.validators_namespace', "$rootNamespace\Validators");
    }

    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the mailable already exists'],
        ];
    }
}