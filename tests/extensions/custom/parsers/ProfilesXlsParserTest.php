<?php

namespace Directus\Custom\Parsers;

use PHPUnit\Framework\TestCase;
use Directus\Custom\Parsers\ProfilesXlsParser;

/**
 * @coversDefaultClass \Directus\Custom\Parsers\ProfilesXlsParser
 */
class ProfilesXlsParserTest extends TestCase {

    /**
     * Tests parse method of ProfilesXlsParser
     *
     * @covers ::parse
     * @dataProvider provideXlsFiles
     */
    public function testParse(
        $filePath,
        $expectedStartFiveRecords,
        $expectedLastFiveRecords
    ) {
        $parser = new ProfilesXlsParser();
        $resultedArray = $parser->parse($filePath);
        $this->assertCount(53, $resultedArray);
        $startFiveRecords = array_slice($resultedArray, 0, 5);
        $endFiveRecords = array_slice($resultedArray, -5);
        $this->assertEquals($expectedStartFiveRecords, $startFiveRecords);
        $this->assertEquals($expectedLastFiveRecords, $endFiveRecords);
    }

    public function provideXlsFiles()
    {
        $firstFiveRecords = [
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '704001',
                'group_name' => 'נתיבות',
                'fullname' => 'דהן משה ואורית - 803 חדש',
                'email' => 'tamarsn12@gmail.com',
                'passport' => '200503308',
                'phone_1' => '03-6196934',
                'phone_2' => '050-4110079',
                'home_address' => null,
                'building_plot' => '803',
                'building_number' => 'D13',
                'floor' => 'קרקע',
                'apartment' => '1',
                'rooms' => "גן 4 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '703001',
                'group_name' => 'נתיבות',
                'fullname' => 'גרשון הכהן טל - 803',
                'email' => 'mishcan1@gmail.com',
                'passport' => '36904233',
                'phone_1' => '054-8483339',
                'phone_2' => null,
                'home_address' => null,
                'building_plot' => '803',
                'building_number' => 'D13',
                'floor' => '1',
                'apartment' => '2',
                'rooms' => "4 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '760001',
                'group_name' => 'נתיבות',
                'fullname' => 'סרבר בני - 803',
                'email' => null,
                'passport' => '40357485',
                'phone_1' => null,
                'phone_2' => '02-5714066',
                'home_address' => null,
                'building_plot' => '803',
                'building_number' => 'D13',
                'floor' => '1',
                'apartment' => '3',
                'rooms' => "4 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '780002',
                'group_name' => 'נתיבות',
                'fullname' => 'פסל משה ומיכל - 803 חדש',
                'email' => null,
                'passport' => '38120002',
                'phone_1' => '052-7170229',
                'phone_2' => '077-2177775',
                'home_address' => null,
                'building_plot' => '803',
                'building_number' => 'D13',
                'floor' => '1',
                'apartment' => '4',
                'rooms' => "3 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '711011',
                'group_name' => 'נתיבות',
                'fullname' => 'קורן מיכה -803',
                'email' => 'lealeam1@gmail.com',
                'passport' => '68253962',
                'phone_1' => null,
                'phone_2' => null,
                'home_address' => 'סמטת אזר 6 בני ברק',
                'building_plot' => '803',
                'building_number' => 'D13',
                'floor' => '2',
                'apartment' => '5',
                'rooms' => "4 חד'",
            ],
        ];

        $lastFiveRecords = [
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '804016',
                'group_name' => 'נתיבות',
                'fullname' => 'דירה כרמל - 804',
                'email' => null,
                'passport' => null,
                'phone_1' => '052-7631102',
                'phone_2' => '03-6181238',
                'home_address' => 'רח יוחנן בן זכאי 95/7 אלעד',
                'building_plot' => '804',
                'building_number' => 'C12',
                'floor' => '2',
                'apartment' => '8',
                'rooms' => "3 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => null,
                'group_name' => 'נתיבות',
                'fullname' => 'דירה כרמל- 804',
                'email' => 'dv119903@gmail.com',
                'passport' => null,
                'phone_1' => '054-8450737',
                'phone_2' => '03-6196480',
                'home_address' => 'שרי ישראל 1 כניסה ב ירושלים',
                'building_plot' => '804',
                'building_number' => 'C12',
                'floor' => '3',
                'apartment' => '9',
                'rooms' => "4 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '804019',
                'group_name' => 'נתיבות',
                'fullname' => 'גולדברג מנחם (קירזון פנחס)- 804',
                'email' => 'mvaknin3232@gmail.com',
                'passport' => '43235688',
                'phone_1' => '053-3172895',
                'phone_2' => '053-3107908',
                'home_address' => 'ישעיהו 6 בני ברק',
                'building_plot' => '804',
                'building_number' => 'C12',
                'floor' => '3',
                'apartment' => '10',
                'rooms' => "3 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '804000',
                'group_name' => 'נתיבות',
                'fullname' => 'אהרונוביץ במקום ריזל-804',
                'email' => 'a8933@okmail.co.il',
                'passport' => '301339651',
                'phone_1' => '054-8443412',
                'phone_2' => null,
                'home_address' => 'חזני 1139/11 נתיבות',
                'building_plot' => '804',
                'building_number' => 'C12',
                'floor' => '3',
                'apartment' => '11',
                'rooms' => "3 חד'",
            ],
            [
                'updated_date' => '2018-12-31',
                'contract_number' => '770002',
                'group_name' => 'נתיבות',
                'fullname' => 'עובדיה מרדכי וסימה - 804',
                'email' => 'פקס 089944698',
                'passport' => '25637281',
                'phone_1' => null,
                'phone_2' => null,
                'home_address' => 'קהילות יעקב 5/2 נתיבות',
                'building_plot' => '804',
                'building_number' => 'C12',
                'floor' => '4',
                'apartment' => '12',
                'rooms' => "דירת גג 5 חד'",
            ],
        ];

        return [
            [
                __DIR__ . '/files/profiles_openoffice.xls',
                $firstFiveRecords,
                $lastFiveRecords,
            ],
        ];
    }
}
