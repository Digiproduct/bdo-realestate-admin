<?php

return [
    'filters' => [
        'item.create.imports:before' => new \Directus\Custom\Hooks\Imports\BeforeCreateImport(),
    ]
];
