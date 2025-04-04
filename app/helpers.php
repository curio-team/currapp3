<?php

if (!function_exists('user')) {
    /**
     * Get the currently logged in user model.
     *
     * @return \App\Models\User|null
     */
    function user(): \App\Models\User|null
    {
        return auth()->user();
    }
}

if (!function_exists('weeks_api_url')) {
    /**
     * Build a URL to the weeks API.
     *
     * @param string $path
     * @return string
     */
    function weeks_api_url(string $path = ''): string
    {
        $apiUrl = config('app.weeks.api_url');

        if ($path && $path[0] !== '/') {
            $path = '/' . $path;
        }

        if ($apiUrl && substr($apiUrl, -1) !== '/') {
            $apiUrl .= '/';
        }

        return $apiUrl . $path;
    }
}
