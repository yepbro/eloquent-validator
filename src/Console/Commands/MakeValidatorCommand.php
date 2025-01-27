<?php

namespace YepBro\EloquentValidator\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use YepBro\EloquentValidator\Constants;

use function config;

class MakeValidatorCommand extends GeneratorCommand
{
    protected $name = 'make:validator';

    protected $description = 'Create a new validator class';

    protected function getStub(): string
    {
        return __DIR__ . '/../../../stubs/validator.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return config(Constants::KEY . '.validators_namespace', "$rootNamespace\Validators"); // @phpstan-ignore return.type
    }

    /**
     * @return array<int, array<int, int|string>>
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the validator already exists'],
        ];
    }
}
