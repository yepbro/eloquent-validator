<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use YepBro\EloquentValidator\EloquentValidatorServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Get package providers.
     *
     * @param Application $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            EloquentValidatorServiceProvider::class,
        ];
    }
}