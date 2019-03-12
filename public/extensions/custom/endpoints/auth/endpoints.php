<?php

require __DIR__ . '/controllers/ForgotPassword.php';
require __DIR__ . '/controllers/ResetPassword.php';

return [
  // The endpoint path:
  // '' means it is located at: `/custom/<endpoint-id>`
  // '/` means it is located at: `/custom/<endpoint-id>/`
  // 'test' and `/test` means it is located at: `/custom/<endpoint-id>/test
  // if the handler is a Closure or Anonymous function, it's binded to the app container. Which means $this = to the app container.
  '/password/reset' => [
    'method' => 'POST',
    'handler' => ForgotPassword::class
  ],
  '/password/reset/{token}' => [
    'method' => 'POST',
    'handler' => ResetPassword::class
  ]
];
