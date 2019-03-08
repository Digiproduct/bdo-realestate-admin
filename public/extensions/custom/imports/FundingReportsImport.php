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

class FundingReportsImport extends AbstractImport
{
    /* @var string Funding reports collection name */
    const COLLECTION_FUNDING_REPORTS = 'funding_reports';

    /* @var string Transactions collection name */
    const COLLECTION_TRANSACTIONS = 'transactions';

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

        $truncatedTable = self::COLLECTION_FUNDING_REPORTS;
        $conn = $this->container->get('database')->connect();
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        $truncatedTable = self::COLLECTION_TRANSACTIONS;
        $stmt = $conn->prepare("TRUNCATE `{$truncatedTable}`");
        $stmt->execute();

        foreach ($filtered as $reportData) {
            try {
                $transactions = $reportData['transactions'];
                unset($reportData['transactions']);
                $report = $this->createFundingReport($reportData);
                foreach ($transactions as $transactionData) {
                    $transactionData['funding_report'] = $report['id'];
                    $transactionData['created_by'] = $reportData['created_by'];
                    $this->createTransaction($transactionData);
                }
            } catch (InvalidRequestException $ex) {
                $rejected++;
            } catch (DuplicateItemException $ex) {
                $rejected++;
            } catch (UnprocessableEntityException $ex) {
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
    private function createFundingReport($payload)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        $payload['status'] = 'published';
        $payload['created_on'] = $createdOn->format('Y-m-d H:i:s');
        try {
            $report = $itemsService->createItem(self::COLLECTION_FUNDING_REPORTS, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $report['data'];
    }

    /**
     * @codeCoverageIgnore
     */
    private function createTransaction($payload)
    {
        $itemsService = new ItemsService($this->container);
        $createdOn = new DateTime();
        $payload['status'] = 'published';
        $payload['created_on'] = $createdOn->format('Y-m-d H:i:s');
        try {
            $transaction = $itemsService->createItem(self::COLLECTION_TRANSACTIONS, $payload);
        } catch (InvalidRequestException $ex) {
            throw $ex;
        } catch (DuplicateItemException $ex) {
            throw $ex;
        } catch (UnprocessableEntityException $ex) {
            throw $ex;
        }
        return $transaction['data'];
    }
}
