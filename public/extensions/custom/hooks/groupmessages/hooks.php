<?php

return [
    'filters' => [
        'item.create.group_messages:before' => new \Directus\Custom\Hooks\GroupMessages\BeforeCreateGroupMessage(),
        'item.update.group_messages:before' => new \Directus\Custom\Hooks\GroupMessages\BeforeCreateGroupMessage(),
    ]
];
