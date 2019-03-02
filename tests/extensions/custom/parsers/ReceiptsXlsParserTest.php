<?php

namespace Directus\Custom\Parsers;

use PHPUnit\Framework\TestCase;
use Directus\Custom\Parsers\ReceiptsXlsParser;

/**
 * @coversDefaultClass \Directus\Custom\Parsers\ReceiptsXlsParser
 */
class ReceiptsXlsParserTest extends TestCase {

    /**
     * Tests parse method of ReceiptsXlsParser
     *
     * @covers ::parse
     * @dataProvider provideXlsFiles
     */
    public function testParse(
        $filePath,
        $expectedRecords
    ) {
        $parser = new ReceiptsXlsParser();
        $resultedArray = $parser->parse($filePath);
        $this->assertCount(count($expectedRecords), $resultedArray);
        $this->assertEquals($expectedRecords, $resultedArray);
    }

    public function provideXlsFiles()
    {
        $records = [
            [
                'contract_number' => '20002',
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
                'contract_number' => '20003',
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
                'contract_number' => '20004',
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
                'contract_number' => '20005',
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
                'contract_number' => '20006',
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
                'contract_number' => '20007',
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
                'contract_number' => '20008',
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
                'contract_number' => '20009',
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
                'contract_number' => '20010',
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
                'contract_number' => '20011',
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
                'request_date' => '=SUM(I5:I14)',
                'request_amount_2' => null,
                'request_description_2' => null,
                'request_date_2' => null,
                'request_amount_3' => null,
                'request_description_3' => null,
                'request_date_3' => null,
                'total_amount' => null,
                'updated_date' => null,
            ],
        ];

        return [
            [
                __DIR__ . '/files/receipts_openoffice.xls',
                $records,
            ],
        ];
    }
}
