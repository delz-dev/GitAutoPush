<?php

namespace Diffrentdigital\GitAutoPush;

use Illuminate\Support\ServiceProvider;
use Diffrentdigital\GitAutoPush\Console\Commands\GitAutoPushCommand;

class GitAutoPushServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/git-auto-push.php', 'git-auto-push');

        $this->commands([
            GitAutoPushCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/git-auto-push.php' => config_path('git-auto-push.php'),
        ]);

        // Schedule the command to run every 24 hours if the environment is enabled
        $this->app->booted(function () {
            $enabledEnvironments = config('git-auto-push.enabled_environments', []);
            if (in_array($this->app->environment(), $enabledEnvironments)) {
                $schedule = $this->app->make(\Illuminate\Console\Scheduling\Schedule::class);
                $schedule->command('git:auto-push')->daily();
            }
        });
    }
}