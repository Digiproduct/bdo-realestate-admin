<?php

namespace Directus\Custom\Imports;

use Directus\Custom\Imports\AbstractImport;
use Directus\Services\ItemsService;
use Directus\Application\Container;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use DateTime;

class ReceiptsImport extends AbstractImport
{
    /* @var string Balance data collection name */
    const COLLECTION_RECEIPTS = 'receipts';

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

        $truncatedTable = self::COLLECTION_RECEIPTS;
        $conn = $this->container->get('database')->connect();
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        foreach ($filtered as $receipt) {
            try {
                $this->createReceipt($receipt);
            }  catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
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

    /**
     * @codeCoverageIgnore
     */
    private function createReceipt($payload)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        $payload['status'] = 'published';
        $payload['created_on'] = $createdOn->format('Y-m-d H:i:s');
        try {
            $receipt = $itemsService->createItem(self::COLLECTION_RECEIPTS, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        }
        return $receipt['data'];
    }
}
