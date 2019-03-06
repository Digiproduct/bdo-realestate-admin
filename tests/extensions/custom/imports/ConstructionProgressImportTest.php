<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\ConstructionProgressImport;

/**
 * @coversDefaultClass \Directus\Custom\Import\ConstructionProgressImport
 */
class ConstructionProgressImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/construction_progress_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideConstructionProgressData
     */
    public function testExecute($constructionProgress)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/construction_progress_expected.xml');

        $import = new ConstructionProgressImport(self::$container);
        $import->execute($constructionProgress);

        // assert group infos
        $actualGroupsTable = $this->getConnection()->createQueryTable(
            'group_info', 'SELECT `id`, `status`, `phone`, `email`, `photo_1`, `photo_2`, `photo_3`, `photo_4`, `group_name` FROM `group_info`'
        );

        $expectedGroups = new Filter($expectedFixture);
        $expectedGroups->addIncludeTables(['group_info']);
        $expectedGroups->setIncludeColumnsForTable('group_info', [
            'id',
            'status',
            'phone',
            'email',
            'photo_1',
            'photo_2',
            'photo_3',
            'photo_4',
            'group_name',
        ]);

        $this->assertTablesEqual($expectedGroups->getTable('group_info'), $actualGroupsTable);

        // assert construction_progress table
        $actualProgressTable = $this->getConnection()->createQueryTable(
            'construction_progress', 'SELECT `status`, `group`, `milestone_name`, `is_complete` FROM `construction_progress`'
        );

        $expectedProgress = new Filter($expectedFixture);
        $expectedProgress->addIncludeTables(['construction_progress']);
        $expectedProgress->setIncludeColumnsForTable('construction_progress', [
            'status',
            'group',
            'milestone_name',
            'is_complete',
        ]);

        $this->assertTablesEqual($expectedProgress->getTable('construction_progress'), $actualProgressTable);
    }

    public function provideConstructionProgressData()
    {
        return [
            [
                [
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
                ],
            ],
        ];
    }
}
