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
 * @coversDefaultClass \Directus\Custom\Imports\ConstructionProgressImport
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
        $constructionProgressFixture = require(__DIR__ . '/fixtures/construction_progress.inc.php');
        return [
            [
                $constructionProgressFixture,
            ],
        ];
    }
}
