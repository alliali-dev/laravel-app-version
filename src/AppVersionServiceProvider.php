<?php

namespace AllialiDev\AppVersion;

use Illuminate\Support\ServiceProvider;
use AllialiDev\AppVersion\Console\AppVersionCommand;

class AppVersionServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Fusionne la configuration du package avec celles de l'application
        $this->mergeConfigFrom(
            __DIR__ . '/../config/version.php',
            'version'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Permet de publier le fichier de config avec : php artisan vendor:publish
            $this->publishes(
                [
                    __DIR__ . '/../config/version.php' => config_path('version.php'),
                ],
                'app-version-config'
            );
            $this->commands([
                AppVersionCommand::class,
            ]);
        }
    }
}
