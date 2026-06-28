<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    | Cette valeur est l'identifiant de version actuel de votre application.
    | Elle est l'équivalent de config('app.version').
    |
    */
    'current' => file_exists(base_path('version.json'))
        ? json_decode(file_get_contents(base_path('version.json')), true)['version'] ?? '1.0.0'
        : '1.0.0',
];
