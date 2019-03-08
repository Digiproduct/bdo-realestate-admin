<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\ReceiptsImport;

/**
 * @coversDefaultClass \Directus\Custom\Imports\ReceiptsImport
 */
class ReceiptsImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/receipts_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideReceiptsData
     */
    public function testExecute($receiptsData)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/receipts_expected.xml');

        $import = new ReceiptsImport(self::$container);
        $import->execute($receiptsData);

        // assert receiptps data tables
        $actualTable = $this->getConnection()->createQueryTable(
            'receipts', 'SELECT `id`, `status`, `created_by`, `contract_number`, `request_amount`, `request_description`, `request_date`, `request_amount_2`, `request_description_2`, `request_date_2`, `request_amount_3`, `request_description_3`, `request_date_3`, `total_amount`, `updated_date` FROM `receipts`'
        );

        $expectedDataSet = new Filter($expectedFixture);
        $expectedDataSet->setIncludeColumnsForTable('receipts', [
            'id',
            'status',
            'created_by',
            'contract_number',
            'request_amount',
            'request_description',
            'request_date',
            'request_amount_2',
            'request_description_2',
            'request_date_2',
            'request_amount_3',
            'request_description_3',
            'request_date_3',
            'total_amount',
            'updated_date',
        ]);

        $this->assertTablesEqual($expectedDataSet->getTable('receipts'), $actualTable);
    }

    public function provideReceiptsData()
    {
        return [
            [
                [
                    [
                        'contract_number' => '804009',// 25
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804008', //23
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804007', //21
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804006', //20
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804005',//19
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804002',// 22
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => '60000',
                        'request_description_2' => 'description 2',
                        'request_date_2' => '2019-02-15',
                        'request_amount_3' => '10000',
                        'request_description_3' => 'description 3',
                        'request_date_3' => '2019-02-15',
                        'total_amount' => '100000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '804001',// 34
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '780007',// 26
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '750005',// 7
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => '300000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => '721004',// 15
                        'request_amount' => '30000',
                        'request_description' => 'השלמת הון עצמי לפני מימון',
                        'request_date' => '2019-02-15',
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => '60000',
                        'request_description_3' => 'description 3',
                        'request_date_3' => '2019-02-15',
                        'total_amount' => '150000',
                        'updated_date' => '2019-01-08',
                    ],
                    [
                        'contract_number' => null,
                        'request_amount' => '300000',
                        'request_description' => null,
                        'request_date' => 435110,
                        'request_amount_2' => null,
                        'request_description_2' => null,
                        'request_date_2' => null,
                        'request_amount_3' => null,
                        'request_description_3' => null,
                        'request_date_3' => null,
                        'total_amount' => null,
                        'updated_date' => null,
                    ],
                ],
            ],
        ];
    }
}
