<?php

namespace Diffrentdigital\GitAutoPush\Tests\Console\Commands;

use Diffrentdigital\GitAutoPush\Commands\GitAutoPushCommand;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class GitAutoPushCommandTest extends TestCase
{
    public function testHandle()
    {
        // Mock the Process class
        $processMock = $this->createMock(Process::class);
        $processMock->method('run')->willReturn(true);
        $processMock->method('isSuccessful')->willReturn(true);

        // Replace the Process class with the mock
        $this->app->instance(Process::class, $processMock);

        // Run the command
        Artisan::call('git:auto-push');

        // Assert the command output
        $this->assertStringContainsString('Starting git auto-push process...', Artisan::output());
        $this->assertStringContainsString('Git auto-push process completed successfully.', Artisan::output());
    }

    public function testHandleFailsToAddChanges()
    {
        // Mock the Process class
        $processMock = $this->createMock(Process::class);
        $processMock->method('run')->willReturn(true);
        $processMock->method('isSuccessful')->willReturnOnConsecutiveCalls(false, true, true);

        // Replace the Process class with the mock
        $this->app->instance(Process::class, $processMock);

        // Run the command
        Artisan::call('git:auto-push');

        // Assert the command output
        $this->assertStringContainsString('Starting git auto-push process...', Artisan::output());
        $this->assertStringContainsString('Failed to add changes.', Artisan::output());
    }

    public function testHandleFailsToCommitChanges()
    {
        // Mock the Process class
        $processMock = $this->createMock(Process::class);
        $processMock->method('run')->willReturn(true);
        $processMock->method('isSuccessful')->willReturnOnConsecutiveCalls(true, false, true);

        // Replace the Process class with the mock
        $this->app->instance(Process::class, $processMock);

        // Run the command
        Artisan::call('git:auto-push');

        // Assert the command output
        $this->assertStringContainsString('Starting git auto-push process...', Artisan::output());
        $this->assertStringContainsString('Failed to commit changes.', Artisan::output());
    }

    public function testHandleFailsToPushChanges()
    {
        // Mock the Process class
        $processMock = $this->createMock(Process::class);
        $processMock->method('run')->willReturn(true);
        $processMock->method('isSuccessful')->willReturnOnConsecutiveCalls(true, true, false);

        // Replace the Process class with the mock
        $this->app->instance(Process::class, $processMock);

        // Run the command
        Artisan::call('git:auto-push');

        // Assert the command output
        $this->assertStringContainsString('Starting git auto-push process...', Artisan::output());
        $this->assertStringContainsString('Failed to push changes.', Artisan::output());
    }
}