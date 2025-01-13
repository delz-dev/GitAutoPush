<?php

namespace Diffrentdigital\GitAutoPush;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Diffrentdigital\GitAutoPush\Console\Commands\GitAutoPushCommand;

class GitAutoPushServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/git-auto-push.php', 'git-auto-push');

        $this->commands([
            Commands\GitAutoPushCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/git-auto-push.php' => config_path('git-auto-push.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'git-auto-push');

        $this->loadRoutesFrom(__DIR__.'/../routes/cp.php');
    }
}