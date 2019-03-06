<?php

namespace Directus\Custom\Imports;

use Directus\Custom\Imports\AbstractImport;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use DateTime;

class ConstructionProgressImport extends AbstractImport
{
    /* @var string Group info collection name */
    const COLLECTION_GROUP_INFO = 'group_info';

    /* @var string Construction progress collection name */
    const COLLECTION_CONSTRUCTION_PROGRESS = 'construction_progress';

    /**
     * Executes the import process.
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

        $truncatedTable = self::COLLECTION_CONSTRUCTION_PROGRESS;
        $conn = $this->container->get('database')->connect();
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        foreach ($data as $progress) {
            try {
                $progress['group_id'] = $groups[$progress['group_name']]['id'];
                $this->createConstructionProgress($progress);
            }  catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            }
        }
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
        }
        return $group['data'];
    }

    private function createConstructionProgress($payload)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        $groupId = $payload['group_id'];
        $milestoneName = (!empty($payload['milestone_name'])) ? $payload['milestone_name'] : null;
        $isComplete = (bool) $payload['is_complete'];
        $updatedDate =(!empty($payload['updated_date'])) ? $payload['updated_date'] : null;
        try {
            $progress = $itemsService->createItem(self::COLLECTION_CONSTRUCTION_PROGRESS, [
                'status' => 'published',
                'created_by' => 1,
                'created_on' => $createdOn->format('Y-m-d H:i:s'),
                'group' => $groupId,
                'milestone_name' => $milestoneName,
                'is_complete' => $isComplete,
                'updated_date' => $updatedDate,
            ]);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        }
        return $progress['data'];
    }
}
