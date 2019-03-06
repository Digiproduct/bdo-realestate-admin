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
 * @coversDefaultClass \Directus\Custom\Import\BalanceDataImport
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
        return [
            [
                [
                    [
                        'contract_number' => '702002', // 12
                        'unit_cost' => 1950000,
                        'funds' => 1100000,
                        'land_amount' => 1000000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -98959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '20002',
                        'unit_cost' => 1910000,
                        'funds' => 955000,
                        'land_amount' => 960000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -203959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '720018', // 30
                        'unit_cost' => 2025000,
                        'funds' => 945000,
                        'land_amount' => 1075000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -328959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '731009', //10
                        'unit_cost' => 2100000,
                        'funds' => 500000,
                        'land_amount' => 1150000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -298959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '750003', //16
                        'unit_cost' => 2040000,
                        'funds' => 985000,
                        'land_amount' => 1090000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -303959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804000', //34
                        'unit_cost' => 1990000,
                        'funds' => 796000,
                        'land_amount' => 1040000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -378959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804010',//27
                        'unit_cost' => 2050000,
                        'funds' => 1720000,
                        'land_amount' => 1100000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => 421041,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804015',// 31
                        'unit_cost' => 2050000,
                        'funds' => 700000,
                        'land_amount' => 1100000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -598959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '721001',// 17
                        'unit_cost' => 2000000,
                        'funds' => 500000,
                        'land_amount' => 1050000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => -248959,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '704001', //4
                        'unit_cost' => 2050000,
                        'funds' => 1650000,
                        'land_amount' => 1100000,
                        'land_completeness' => 100,
                        'construction_amount' => 186830,
                        'construction_completeness' => 21,
                        'management_amount' => 12128,
                        'management_completeness' => 24,
                        'balance' => 351041,
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => null,
                        'unit_cost' => 20165000,
                        'funds' => 9851000,
                        'land_amount' => 26860000,
                        'land_completeness' => null,
                        'construction_amount' => 1868303,
                        'construction_completeness' => null,
                        'management_amount' => 121284,
                        'management_completeness' => null,
                        'balance' => -17884587,
                        'updated_date' => null,
                    ],
                ],
            ],
        ];
    }
}
