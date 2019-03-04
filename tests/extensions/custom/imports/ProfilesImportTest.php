<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\ProfilesImport;

/**
 * @coversDefaultClass \Directus\Custom\Import\ProfilesImport
 */
class ProfilesImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/profiles_import_setup.xml');
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
        $import = new ProfilesImport();
        $import->execute([]);

        $actualTable = $this->getConnection()->createQueryTable(
            'directus_users', 'SELECT `status`, `first_name`, `last_name`, `email`, `timezone`, `email_notifications` FROM `directus_users`'
        );

        $expectedDataSet = new Filter(
            $this->createMySQLXMLDataSet(__DIR__ . '/files/profiles_import_expected.xml')
        );
        $expectedDataSet->addIncludeTables(['directus_users']);
        $expectedDataSet->setIncludeColumnsForTable('directus_users', [
            'status',
            'first_name',
            'last_name',
            'email',
            'timezone',
            'email_notifications',
        ]);

        $this->assertTablesEqual($expectedDataSet->getTable('directus_users'), $actualTable);

        // assert directus_user_roles

        // test goes here
    }
}