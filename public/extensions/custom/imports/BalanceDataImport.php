<?php

namespace Directus\Custom\Imports;

use Directus\Custom\Imports\AbstractImport;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use Directus\Exception\UnprocessableEntityException;
use DateTime;

class BalanceDataImport extends AbstractImport
{
    /* @var string Balance data collection name */
    const COLLECTION_BALANCE_DATA = 'balance_data';

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

        // find all contracts by primary key
        $mapped = array_map(function($item) {
            $contract = $this->getContract($item['contract_number']);
            if ($contract) {
                return array_merge($item, [
                    'created_by' => $contract['customer'],
                ]);
            }
            $this->rejectedItems[] = $item;
            return null;
        }, $data);

        $filtered = array_filter($mapped, function($item)  {
            return $item !== null;
        });

        if (count($filtered) === 0) {
            return;
        }

        $truncatedTable = self::COLLECTION_BALANCE_DATA;
        $conn = $this->container->get('database')->connect();
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        foreach ($filtered as $balance) {
            try {
                $this->container->get('acl')->setUserId($balance['created_by']);
                $this->createBalanceData($balance);
                $this->createdItems[] = $balance;
            } catch (InvalidRequestException $ex) {
                $this->addRejectedItem($balance, $ex->getMessage());
            } catch (DuplicateItemException $ex) {
                $this->addRejectedItem($balance, $ex->getMessage());
            } catch (UnprocessableEntityException $ex) {
                $this->addRejectedItem($balance, $ex->getMessage());
            }
        }
    }

    private function getContract($contractNumber)
    {
        $itemsService = new ItemsService($this->container);
        try {
            $contract = $itemsService->find(self::COLLECTION_CONTRACTS, $contractNumber);
        } catch (ItemNotFoundException $ex) {
            return null;
        }

        return $contract['data'];
    }

    private function createBalanceData($payload)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        $payload['status'] = 'published';
        $payload['created_on'] = $createdOn->format('Y-m-d H:i:s');
        try {
            $balanceItem = $itemsService->createItem(self::COLLECTION_BALANCE_DATA, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $balanceItem['data'];
    }
}
