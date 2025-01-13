<?php

namespace Diffrentdigital\GitAutoPush;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/git-auto-push.php', 'git-auto-push');

        $this->commands([
            Commands\GitAutoPushCommand::class,
        ]);
    }

    public function bootAddon()
    {
        $this->publishes([
            __DIR__.'/../config/git-auto-push.php' => config_path('git-auto-push.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'git-auto-push');

        $this->loadRoutesFrom(__DIR__.'/../routes/cp.php');
    }
}