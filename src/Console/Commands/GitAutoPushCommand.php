<?php

namespace Diffrentdigital\GitAutoPush\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GitAutoPushCommand extends Command
{
    protected $signature = 'git:auto-push';
    protected $description = 'Automatically add, commit, and push changes to the git repository every 24 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting git auto-push process...');

        $process = new Process(['git', 'add', '.']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Failed to add changes.');
            return;
        }

        $process = new Process(['git', 'commit', '-m', 'Automated commit']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Failed to commit changes.');
            return;
        }

        $process = new Process(['git', 'push']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Failed to push changes.');
            return;
        }

        $this->info('Git auto-push process completed successfully.');
    }
}