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
        $receiptsFixture = require(__DIR__ . '/fixtures/receipts.inc.php');
        return [
            [
                $receiptsFixture,
            ],
        ];
    }
}
