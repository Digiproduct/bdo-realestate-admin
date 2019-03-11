<?php

return [
    'filters' => [
        'item.create.feedback:before' => new \Directus\Custom\Hooks\Feedback\BeforeCreateFeedback(),
    ],
    'actions' => [
        'item.create.feedback:after' => new \Directus\Custom\Hooks\Feedback\AfterCreateFeedback(),
    ],
];
