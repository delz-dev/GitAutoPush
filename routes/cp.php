<?php

use Illuminate\Support\Facades\Route;
use Diffrentdigital\GitAutoPush\Http\Controllers\SettingsController;

Route::middleware('web')->group(function () {
    Route::get('git-auto-push/settings', [SettingsController::class, 'index'])->name('git-auto-push.settings');
    Route::post('git-auto-push/settings', [SettingsController::class, 'update'])->name('git-auto-push.settings.update');
});