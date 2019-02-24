<?php

namespace Directus\Custom\Hooks\Messages;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;

class BeforeCreateMessage implements HookInterface
{
    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        if ($payload->has('to')) {
            $payload->set('created_by', $payload->get('to'));
        }

        // make sure to return the payload
        return $payload;
    }
}
