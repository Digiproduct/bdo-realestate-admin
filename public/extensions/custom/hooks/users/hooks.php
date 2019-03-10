<?php

return [
    'actions' => [
        'item.create.directus_users:after' => new \Directus\Custom\Hooks\Users\AfterCreateUser(),
    ]
];
