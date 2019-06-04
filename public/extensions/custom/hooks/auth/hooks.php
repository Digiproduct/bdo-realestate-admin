<?php

return [
    'actions' => [
        'auth.request:credentials' => new \Directus\Custom\Hooks\Auth\AuthRequestCredentials(),
    ],
];
