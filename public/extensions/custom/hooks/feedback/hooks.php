<?php

return [
    'filters' => [
        'item.create.feedback:before' => new \Directus\Custom\Hooks\Feedback\BeforeCreateFeedback(),
    ]
];
