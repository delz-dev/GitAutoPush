@extends('statamic::layout')
@section('title', 'Git Auto Push Settings')

@section('content')
    <h1>Git Auto Push Settings</h1>

    <form method="POST" action="{{ cp_route('git-auto-push.settings.update') }}">
        @csrf
        <div class="card p-3">
            <div class="form-group">
                <label for="enabled">Enable Addon</label>
                <input type="checkbox" name="enabled" id="enabled" value="1" {{ config('git-auto-push.enabled') ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="environments">Allowed Environments</label>
                <select name="environments[]" id="environments" multiple>
                    <option value="local" {{ in_array('local', config('git-auto-push.enabled_environments', [])) ? 'selected' : '' }}>Local</option>
                    <option value="staging" {{ in_array('staging', config('git-auto-push.enabled_environments', [])) ? 'selected' : '' }}>Staging</option>
                    <option value="production" {{ in_array('production', config('git-auto-push.enabled_environments', [])) ? 'selected' : '' }}>Production</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
@endsection