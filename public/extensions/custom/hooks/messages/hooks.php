<?php

return [
    'filters' => [
        'item.create.messages:before' => new \Directus\Custom\Hooks\Messages\BeforeCreateMessage(),
        'item.update.messages:before' => new \Directus\Custom\Hooks\Messages\BeforeCreateMessage(),
    ]
];
