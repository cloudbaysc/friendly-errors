<?php

return [
    'auto_attach_middlewares' => true,

    'support' => [
        'email'    => env('FRIENDLY_ERRORS_SUPPORT_EMAIL', 'support@cloudbay.sc'),
        'phone'    => env('FRIENDLY_ERRORS_SUPPORT_PHONE', '+248 2xx xxxx'),
        'whatsapp' => env('FRIENDLY_ERRORS_SUPPORT_WHATSAPP', null),
        'hours'    => env('FRIENDLY_ERRORS_SUPPORT_HOURS', 'Mon–Fri 09:00–17:00 SCT'),
        'docs_url' => env('FRIENDLY_ERRORS_DOCS_URL', null),
    ],

    'view' => 'friendly-errors::errors.500',
];
