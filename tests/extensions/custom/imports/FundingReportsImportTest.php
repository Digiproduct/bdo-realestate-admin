<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\FundingReportsImport;

/**
 * @coversDefaultClass \Directus\Custom\Imports\FundingReportsImport
 */
class FundingReportsImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/funding_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideReportsData
     */
    public function testExecute($reportsData)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/funding_expected.xml');

        $import = new FundingReportsImport(self::$container);
        $import->execute($reportsData);

        // assert funding reports data tables
        $actualReportsTable = $this->getConnection()->createQueryTable(
            'funding_reports', 'SELECT `id`, `status`, `created_by`, `contract_number`, `date_range`, `total_debit`, `total_credit`, `total_balance`, `updated_date` FROM `funding_reports`'
        );

        $expectedReportsDataSet = new Filter($expectedFixture);
        $expectedReportsDataSet->setIncludeColumnsForTable('funding_reports', [
            'id',
            'status',
            'created_by',
            'contract_number',
            'date_range',
            'total_debit',
            'total_credit',
            'total_balance',
            'updated_date',
        ]);

        $this->assertTablesEqual($expectedReportsDataSet->getTable('funding_reports'), $actualReportsTable);

        // assert transactions table
        $actualTransactionsTable = $this->getConnection()->createQueryTable(
            'transactions', 'SELECT `id`, `status`, `created_by`, `funding_report`, `title`, `move`, `ration`, `counter_account`, `date_1`, `date_2`, `reference_1`, `reference_2`, `details`, `debit`, `credit`, `balance` FROM `transactions`'
        );

        $expectedTransactionsDataSet = new Filter($expectedFixture);
        $expectedTransactionsDataSet->setIncludeColumnsForTable('transactions', [
            'id',
            'status',
            'created_by',
            'funding_report',
            'title',
            'move',
            'ration',
            'counter_account',
            'date_1',
            'date_2',
            'reference_1',
            'reference_2',
            'details',
            'debit',
            'credit',
            'balance',
        ]);

        $this->assertTablesEqual($expectedTransactionsDataSet->getTable('transactions'), $actualTransactionsTable);
    }

    public function provideReportsData()
    {
        $fundingReports = require(__DIR__ . '/fixtures/funding_reports.inc.php');
        return [
            [
                $fundingReports,
            ],
        ];
    }
}
