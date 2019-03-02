<?php

namespace Directus\Custom\Parsers;

use PHPUnit\Framework\TestCase;
use Directus\Custom\Parsers\ConstructionProgressXlsParser;

/**
 * @coversDefaultClass \Directus\Custom\Parsers\ConstructionProgressXlsParser
 */
class ConstructionProgressXlsParserTest extends TestCase {

    /**
     * Tests parse method of ConstructionProgressXlsParser
     *
     * @covers ::parse
     * @dataProvider provideXlsFiles
     */
    public function testParse(
        $filePath,
        $expectedRecords
    ) {
        $parser = new ConstructionProgressXlsParser();
        $resultedArray = $parser->parse($filePath);
        $this->assertCount(count($expectedRecords), $resultedArray);
        $this->assertEquals($expectedRecords, $resultedArray);
    }

    public function provideXlsFiles()
    {
        $records = [
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'נובמבר 2013 - זכיה במכרז',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'ינואר 2014- הסכם שיתוף',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'אוקטובר 2014- תכנון ובקשת היתר',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'ינואר 2015- הכנת דוח אפס',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'אוקטובר 2015 - ליווי בנקאי',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'ינואר 2016- התחלת בניה',
                'is_complete' => true,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'דצמבר 2016- סיום שלד',
                'is_complete' => false,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'יולי 2017- סיום מערכות בניין',
                'is_complete' => false,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'דצמבר 2017- גימורים ופיתוח',
                'is_complete' => false,
            ],
            [
                'updated_date' => '2019-01-08',
                'group_name' => 'קבוצת אחיסמך',
                'milestone_name' => 'פברואר 2018- קבלת מפתחות',
                'is_complete' => false,
            ],
        ];

        return [
            [
                __DIR__ . '/files/construction_progress_openoffice.xls',
                $records,
            ],
        ];
    }
}
