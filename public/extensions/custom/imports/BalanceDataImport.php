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
        $rejected = 0;

        // find all contracts by primary key
        $mapped = array_map(function($item) {
            $contract = $this->getContract($item['contract_number']);
            if ($contract) {
                return array_merge($item, [
                    'created_by' => $contract['customer'],
                ]);
            }
            return null;
        }, $data);

        $filtered = array_filter($mapped, function($item)  {
            return $item !== null;
        });

        if (count($filtered) === 0) {
            $rejected = count($data);
            return;
        }

        $truncatedTable = self::COLLECTION_BALANCE_DATA;
        $conn = $this->container->get('database')->connect();
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        foreach ($filtered as $balance) {
            try {
                $this->createBalanceData($balance);
            } catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            } catch (UnprocessableEntityException $ex) {
                $rejected++;
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
