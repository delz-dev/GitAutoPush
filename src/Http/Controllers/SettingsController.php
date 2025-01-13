<?php

namespace Diffrentdigital\GitAutoPush\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;

class SettingsController extends CpController
{
    public function index()
    {
        return view('git-auto-push::cp.settings');
    }

    public function update(Request $request)
    {
        // Speichere die Einstellungen
        $config = config('git-auto-push');
        $config['enabled'] = $request->has('enabled');
        $config['enabled_environments'] = $request->input('environments', []);

        // Speichere die Konfigurationsdatei
        file_put_contents(config_path('git-auto-push.php'), '<?php return ' . var_export($config, true) . ';');

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}