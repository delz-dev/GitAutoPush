<?php

namespace Diffrentdigital\GitAutoPush;

use Statamic\Providers\AddonServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Diffrentdigital\GitAutoPush\Commands\GitAutoPushCommand;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/git-auto-push.php', 'git-auto-push');

        $this->commands([
            GitAutoPushCommand::class,
        ]);
    }

    public function bootAddon()
    {
        $this->publishes([
            __DIR__.'/../config/git-auto-push.php' => config_path('git-auto-push.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'git-auto-push');

        $this->loadRoutesFrom(__DIR__.'/../routes/cp.php');

        // Schedule the command to run every 24 hours if the environment is enabled
        if (in_array($this->app->environment(), config('git-auto-push.enabled_environments', []))) {
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('git:auto-push')->daily();
            });
        }
    }
}