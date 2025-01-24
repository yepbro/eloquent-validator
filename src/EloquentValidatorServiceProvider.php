<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator;

use Composer\InstalledVersions;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class EloquentValidatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/' . Constants::KEY . '.php', Constants::KEY);
    }

    public function boot(): void
    {
        AboutCommand::add('Eloquent Validator Package', fn() => [
            'Version' => InstalledVersions::getPrettyVersion(Constants::PACKAGE),
        ]);

        $this->publishes([
            __DIR__ . '/../config/' . Constants::KEY . '.php' => config_path(Constants::KEY . '.php')
        ]);
    }
}