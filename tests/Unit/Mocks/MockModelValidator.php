<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use YepBro\EloquentValidator\ModelValidator;

class MockModelValidator extends ModelValidator
{
    use MagicalAccessTrait;

    protected function validatorFactory(): Factory
    {
        $loader = new FileLoader(new Filesystem(), dirname(__FILE__) . '/lang');
        $loader->load('en', 'validation', 'lang');
        $loader->addNamespace('/lang', dirname(__FILE__) . '/lang');

        return new Factory(new Translator($loader, 'en'));
    }
}