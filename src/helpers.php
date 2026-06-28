<?php

if (!function_exists('app_version')) {
    function app_version()
    {
        $path = base_path('version.json');
        if (!file_exists($path)) {
            return '1.0.0';
        }
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        return $data['version'] ?? '1.0.0';
    }
}

if (!function_exists('app_version_display')) {
    function app_version_display()
    {
        return 'v' . app_version();
    }
}

if (!function_exists('app_version_history')) {
    function app_version_history()
    {
        $path = base_path('version.json');
        if (!file_exists($path)) {
            return [];
        }
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        return $data['history'] ?? [];
    }
}

if (!function_exists('app_version_last_update')) {
    function app_version_last_update()
    {
        $path = base_path('version.json');
        if (!file_exists($path)) {
            return null;
        }
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        return $data['last_updated'] ?? null;
    }
}
