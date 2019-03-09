<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\BalanceDataImport;

/**
 * @coversDefaultClass \Directus\Custom\Imports\BalanceDataImport
 */
class BalanceDataImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/balance_data_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideBalanceData
     */
    public function testExecute($balanceData)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/balance_data_expected.xml');

        $import = new BalanceDataImport(self::$container);
        $import->execute($balanceData);

        // assert balance data tables
        $actualTable = $this->getConnection()->createQueryTable(
            'balance_data', 'SELECT `id`, `status`, `created_by`, `contract_number`, `unit_cost`, `funds`, `land_amount`, `land_completeness`, `construction_amount`, `construction_completeness`, `management_amount`, `management_completeness`, `balance`, `updated_date` FROM `balance_data`'
        );

        $expectedDataSet = new Filter($expectedFixture);
        $expectedDataSet->setIncludeColumnsForTable('balance_data', [
            'id',
            'status',
            'created_by',
            'contract_number',
            'unit_cost',
            'funds',
            'land_amount',
            'land_completeness',
            'construction_amount',
            'construction_completeness',
            'management_amount',
            'management_completeness',
            'balance',
            'updated_date',
        ]);

        $this->assertTablesEqual($expectedDataSet->getTable('balance_data'), $actualTable);
    }

    public function provideBalanceData()
    {
        $balanceDataFixture = require(__DIR__ . '/fixtures/balance_data.inc.php');
        return [
            [
                $balanceDataFixture,
            ],
        ];
    }
}
