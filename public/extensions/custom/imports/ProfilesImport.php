<?php

namespace Directus\Custom\Imports;

use Directus\Services\UsersService;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Schema\SchemaManager;
use Directus\Util\StringUtils;
use Directus\Database\Exception\DuplicateItemException;
use PASSWORD_BCRYPT;

class ProfilesImport
{

    /* @var Container App container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function execute(array $data)
    {
        $userService = new UsersService($this->container);
        $itemsService = new ItemsService($this->container);
        $rejected = 0;

        $customersRole = $itemsService->findOne(SchemaManager::COLLECTION_ROLES, [
            'filter' => [
                'name' => 'Customers',
            ],
        ]);

        foreach ($data as $item) {
            $item = $this->stripPayloadStrings($item);
            $password = StringUtils::random();
            $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);

            $payload = [
                'status' => 'invited',
                'first_name' => $item['fullname'],
                'last_name' => $item['fullname'],
                'email' => $item['email'],
                'password' => $hashed,
                'timezone' => 'Asia/Jerusalem',
                'email_notifications' => 0,
            ];
            try {
                $user = $userService->create($payload);

                $payload = [
                    'user' => $user['data']['id'],
                    'role' => $customersRole['data']['id'],
                ];

                $itemsService->createItem(SchemaManager::COLLECTION_USER_ROLES, $payload);
            } catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            }
        }
    }

    protected function stripPayloadStrings(array $payload)
    {
        if (!is_array($payload)) return $payload;

        foreach ($payload as $key => $value) {
            $payload[$key] = $this->stripString($value);
        }
        return $payload;
    }

    protected function stripString($value)
    {
        if(!is_string($value)) return $value;

        // remove invisible chars
        $value = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value);

        // remove rtl and other special chars
        $value = preg_replace('/(\x{200e}|\x{200f})/u', '', $value);

        return trim($value);
    }
}