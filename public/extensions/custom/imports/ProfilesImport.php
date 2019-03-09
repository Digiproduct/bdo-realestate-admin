<?php

namespace Directus\Custom\Imports;

use Directus\Custom\Imports\AbstractImport;
use Directus\Services\UsersService;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use Directus\Exception\UnprocessableEntityException;
use Directus\Database\Schema\SchemaManager;
use Directus\Util\StringUtils;
use DateTime;
use PASSWORD_BCRYPT;

final class ProfilesImport extends AbstractImport
{
    /* @var string Profiles collection name */
    const COLLECTION_PROFILES = 'profiles';

    /* @var string Group info collection name */
    const COLLECTION_GROUP_INFO = 'group_info';

    /* @var string Contracts collection name */
    const COLLECTION_CONTRACTS = 'contracts';

    /**
     * Executes the import process.
     *
     * @param array $data Import data
     */
    public function execute(array $data)
    {
        $this->createdItems = [];
        $this->rejectedItems = [];

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
            } catch (InvalidRequestException $ex) {
                throw $ex;
            } catch (DuplicateItemException $ex) {
                throw $ex;
            } catch (UnprocessableEntityException $ex) {
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
            $fullname = (array_key_exists('fullname', $item)) ? $item['fullname'] : null;
            $email = (array_key_exists('email', $item)) ? $item['email'] : null;
            $contractNumber = (array_key_exists('contract_number', $item)) ? $item['contract_number'] : null;

            try {
                if (!empty($contractNumber)) {
                    $user = $this->createUser([
                        'status' => 'invited',
                        'first_name' => $fullname,
                        'last_name' => $fullname,
                        'email' => $email,
                        'password' => $hashed,
                        'timezone' => 'Asia/Jerusalem',
                        'email_notifications' => 0,
                    ]);

                    $item['id'] = $user['id'];
                    $this->attachCustomerRole([
                        'user' => $user['id'],
                        'role' => $customersRoleId,
                    ]);

                    $this->createProfile($item);
                    $item['group_id'] = $groups[$item['group_name']]['id'];
                    $this->createContract($item);
                    $this->createdItems[] = $item;
                } else {
                    $this->rejectedItems[] = $item;
                }
            } catch (InvalidRequestException $ex) {
                $this->rejectedItems[] = $item;
            } catch (DuplicateItemException $ex) {
                $this->rejectedItems[] = $item;
            } catch (UnprocessableEntityException $ex) {
                $this->rejectedItems[] = $item;
            }
        }
    }

    private function createContract($payload)
    {
        $itemsService = new ItemsService($this->container);
        $buildingPlot = (!empty($payload['building_plot'])) ? $payload['building_plot'] : null;
        $buildingNumber = (!empty($payload['building_number'])) ? $payload['building_number'] : null;
        $floor = (!empty($payload['floor'])) ? $payload['floor'] : null;
        $apartment = (!empty($payload['apartment'])) ? $payload['apartment'] : null;
        $rooms = (!empty($payload['rooms'])) ? $payload['rooms'] : null;
        $createdOn = new DateTime();
        $contract = null;

        try {
            $contract = $itemsService->createItem(self::COLLECTION_CONTRACTS, [
                'status' => 'published',
                'contract_number' => $payload['contract_number'],
                'group' => $payload['group_id'],
                'customer' => $payload['id'],
                'building_plot' => $buildingPlot,
                'building_number' => $buildingNumber,
                'floor' => $floor,
                'apartment' => $apartment,
                'rooms' => $rooms,
                'created_by' => $payload['id'],
                'created_on' => $createdOn->format('Y-m-d H:i:s'),
            ]);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            return null;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $contract['data'];
    }

    private function createGroupInfo($groupName)
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
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $group['data'];
    }

    private function createUser($payload)
    {
        $userService = new UsersService($this->container);
        try {
            $user = $userService->create($payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $user['data'];
    }

    private function attachCustomerRole($payload)
    {
        $itemsService = new ItemsService($this->container);
        try {
            $itemsService->createItem(SchemaManager::COLLECTION_USER_ROLES, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
    }

    private function findCustomerRoleId($roleName)
    {
        $itemsService = new ItemsService($this->container);
        try {
            $customersRole = $itemsService->findOne(SchemaManager::COLLECTION_ROLES, [
                'filter' => [
                    'name' => $roleName,
                ],
            ]);
        } catch (ItemNotFoundException $ex) {
            throw $ex;
        }

        return $customersRole['data'];
    }

    private function createProfile($payload)
    {
        $itemsService = new ItemsService($this->container);
        $passport = (!empty($payload['passport'])) ? $payload['passport'] : null;
        $phone1 = $this->parsePhone($payload['phone_1'], 'IL');
        $phone2 = $this->parsePhone($payload['phone_2'], 'IL');
        $homeAddress = (!empty($payload['home_address'])) ? $payload['home_address'] : null;
        $createdOn = new DateTime();
        $profile = null;

        try {
            $profile = $itemsService->createItem(self::COLLECTION_PROFILES, [
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
            return null;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }

        return $profile['data'];
    }
}
