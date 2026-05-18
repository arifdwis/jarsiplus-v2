<?php

return [
    'sso' => [
        'url' => env('SSO_SERVER_URL', 'https://sso.samarindakota.go.id'),
        'broker_name' => env('SSO_BROKER_NAME', 'JARSIPLUS'),
        'broker_secret' => env('SSO_BROKER_SECRET', ''),
    ],

    'whatsapp' => [
        'url' => env('GOWA_URL', 'https://gowa.samarindakota.go.id/send/message'),
        'username' => env('GOWA_USERNAME', ''),
        'password' => env('GOWA_PASSWORD', ''),
    ],

    'juri' => [
        'url' => env('JURI_API_PENILAIAN_URL', 'https://juri-jarsiplus.samarindakota.go.id/api/penilaian-juri'),
        'key' => env('JURI_API_KEY', ''),
    ],

    'monografi' => [
        'url' => env('MONOGRAFI_URL', 'https://samarindakota.go.id/api'),
        'key' => env('MONOGRAFI_API_KEY', ''),
    ],
];
