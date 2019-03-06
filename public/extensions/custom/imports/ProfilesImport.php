<?php

namespace Directus\Custom\Imports;

use Directus\Services\UsersService;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use Directus\Database\Schema\SchemaManager;
use Directus\Util\StringUtils;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use DateTime;
use PASSWORD_BCRYPT;

class ProfilesImport
{
    /* @var string Profiles collection name */
    const COLLECTION_PROFILES = 'profiles';

    /* @var string Group info collection name */
    const COLLECTION_GROUP_INFO = 'group_info';

    /* @var Container App container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Executes the import process
     *
     * @param array $data Import data
     */
    public function execute(array $data)
    {
        $rejected = 0;

        $groups = array_reduce($data, function($carry, $item) {
            if (!empty($item['group_name']) && !array_key_exists($item['group_name'], $carry)) {
                $carry[$item['group_name']] = null;
            }
            return $carry;
        }, []);

        // create groups first
        foreach ($groups as $groupName => $value) {
            try {
                $group = $this->createGroupInfo($groupName);
                $groups[$groupName] = $group;
            }  catch (InvalidRequestException $ex) {
                throw $ex;
            } catch (DuplicateItemException $ex) {
                throw $ex;
            }
        }

        // find customer role to apply every profile
        $customersRoleId = $this->findCustomerRoleId('Customers')['id'];

        foreach ($data as $item) {
            $item = $this->stripPayloadStrings($item);

            // as soon as user will not use password right away we can reduce crypto cost
            $password = StringUtils::random();
            $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);

            try {
                $user = $this->createUser([
                    'status' => 'invited',
                    'first_name' => $item['fullname'],
                    'last_name' => $item['fullname'],
                    'email' => $item['email'],
                    'password' => $hashed,
                    'timezone' => 'Asia/Jerusalem',
                    'email_notifications' => 0,
                ]);

                $item['id'] = $user['data']['id'];
                $this->attachCustomerRole([
                    'user' => $user['data']['id'],
                    'role' => $customersRoleId,
                ]);

                $this->createProfile($item);
            } catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            }
        }
    }

    protected function createGroupInfo($groupName)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        try {
            $group = $itemsService->findOne(self::COLLECTION_GROUP_INFO, [
                'filter' => [
                    'group_name' => $groupName,
                ],
            ]);
            return $group['data'];
        } catch (ItemNotFoundException $ex) {
            // that's predictable
        }

        try {
            $group = $itemsService->createItem(self::COLLECTION_GROUP_INFO, [
                'group_name' => $groupName,
                'status' => 'published',
                'created_by' => 1,
                'created_on' => $createdOn->format('Y-m-d H:i:s'),
            ]);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            // it's fine
            throw $ex;
        }
        return $group['data'];
    }

    protected function createUser($payload)
    {
        $userService = new UsersService($this->container);
        try {
            $user = $userService->create($payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        }
        return $user;
    }

    protected function attachCustomerRole($payload)
    {
        $itemsService = new ItemsService($this->container);
        try {
            $itemsService->createItem(SchemaManager::COLLECTION_USER_ROLES, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        }
    }

    protected function findCustomerRoleId($roleName)
    {
        $itemsService = new ItemsService($this->container);
        $customersRole = $itemsService->findOne(SchemaManager::COLLECTION_ROLES, [
            'filter' => [
                'name' => $roleName,
            ],
        ]);

        return $customersRole['data'];
    }

    protected function createProfile($payload)
    {
        $itemsService = new ItemsService($this->container);
        $passport = (!empty($payload['passport'])) ? $payload['passport'] : null;
        $phone1 = $this->parsePhone($payload['phone_1'], 'IL');
        $phone2 = $this->parsePhone($payload['phone_2'], 'IL');
        $homeAddress = (!empty($payload['home_address'])) ? $payload['home_address'] : null;
        $createdOn = new DateTime();

        try {
            $itemsService->createItem(self::COLLECTION_PROFILES, [
                'passport' => $payload['passport'],
                'customer' => $payload['id'],
                'phone_1' => $phone1,
                'phone_2' => $phone2,
                'home_address' => $homeAddress,
                'status' => 'published',
                'created_by' => $payload['id'],
                'created_on' => $createdOn->format('Y-m-d H:i:s'),
            ]);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        }
    }

    protected function parsePhone($phoneStr, $defaultLocale = 'IL')
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($phoneStr, $defaultLocale);
            if ($phoneUtil->isValidNumber($numberProto)) {
                return $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
            }
        } catch (NumberParseException $e) {
            return null;
        }

        return null;
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