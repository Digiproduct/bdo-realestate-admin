<?php

return [
    'filters' => [
        'item.update.profiles:before' => new \Directus\Custom\Hooks\Profiles\BeforeUpdateProfiles(),
    ]
];
