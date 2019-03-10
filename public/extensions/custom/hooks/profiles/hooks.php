<?php

return [
    'filters' => [
        'item.update.profiles:before' => new \Directus\Custom\Hooks\Profiles\BeforeUpdateProfiles(),
    ],
    'actions' => [
        'item.update.profiles:after' => new \Directus\Custom\Hooks\Profiles\AfterUpdateProfiles(),
    ],
];
