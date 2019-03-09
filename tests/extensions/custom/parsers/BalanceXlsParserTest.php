<?php

namespace Directus\Custom\Parsers;

use PHPUnit\Framework\TestCase;
use Directus\Custom\Parsers\BalanceXlsParser;

/**
 * @coversDefaultClass \Directus\Custom\Parsers\BalanceXlsParser
 */
class BalanceXlsParserTest extends TestCase {

    /**
     * Tests parse method of BalanceXlsParser
     *
     * @covers ::parse
     * @dataProvider provideXlsFiles
     */
    public function testParse(
        $filePath,
        $expectedRecords
    ) {
        $parser = new BalanceXlsParser();
        $resultedArray = $parser->parse($filePath);
        $this->assertEquals($expectedRecords, $resultedArray);
    }

    public function provideXlsFiles()
    {
        $records = [
            [
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
                'contract_number' => '20002',
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
        ];

        return [
            [
                __DIR__ . '/files/balance_items.xls',
                $records,
            ],
        ];
    }
}
