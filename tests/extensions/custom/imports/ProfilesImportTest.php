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
 * @coversDefaultClass \Directus\Custom\Imports\ProfilesImport
 */
class ProfilesImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/profiles_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideProfilesData
     */
    public function testExecute($profiles)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/profiles_expected.xml');

        $import = new ProfilesImport(self::$container);
        $import->execute($profiles);

        // assert directus_users
        $actualUsers = $this->getConnection()->createQueryTable(
            'directus_users', 'SELECT `id`, `status`, `first_name`, `last_name`, `email`, `timezone`, `email_notifications` FROM `directus_users`'
        );

        $expectedUsers = new Filter($expectedFixture);
        $expectedUsers->addIncludeTables(['directus_users']);
        $expectedUsers->setIncludeColumnsForTable('directus_users', [
            'id',
            'status',
            'first_name',
            'last_name',
            'email',
            'timezone',
            'email_notifications',
        ]);

        $this->assertTablesEqual($expectedUsers->getTable('directus_users'), $actualUsers);

        // assert directus_user_roles
        $roleTable = $this->getConnection()->createQueryTable(
            'directus_user_roles', 'SELECT * FROM `directus_user_roles`'
        );

        $expectedRoles = new Filter($expectedFixture);
        $expectedRoles->addIncludeTables(['directus_user_roles']);

        $this->assertTablesEqual($expectedRoles->getTable('directus_user_roles'), $roleTable);

        // assert profiles table
        $profilesTable = $this->getConnection()->createQueryTable(
            'profiles', 'SELECT `status`, `created_by`, `passport`, `phone_1`, `phone_2`, `customer`, `home_address` FROM `profiles`'
        );

        $expectedProfiles = new Filter($expectedFixture);
        $expectedProfiles->addIncludeTables(['profiles']);
        $expectedProfiles->setIncludeColumnsForTable('profiles', [
            'status',
            'created_by',
            'passport',
            'phone_1',
            'phone_2',
            'customer',
            'home_address',
        ]);

        $this->assertTablesEqual($expectedProfiles->getTable('profiles'), $profilesTable);

        // assert group infos
        $groupsTable = $this->getConnection()->createQueryTable(
            'group_info',
            'SELECT `status`, `created_by`, `phone`, `email`, `photo_1`, `photo_2`, `photo_3`, `photo_4`, `group_name` FROM `group_info`'
        );

        $expectedGroups = new Filter($expectedFixture);
        $expectedGroups->addIncludeTables(['group_info']);
        $expectedGroups->setIncludeColumnsForTable('group_info', [
            'status',
            'created_by',
            'phone',
            'email',
            'photo_1',
            'photo_2',
            'photo_3',
            'photo_4',
            'group_name',
        ]);

        $this->assertTablesEqual($expectedGroups->getTable('group_info'), $groupsTable);

        // assert contracts
        $contractsTable = $this->getConnection()->createQueryTable(
            'contracts',
            'SELECT `status`, `created_by`, `building_plot`, `building_number`, `floor`, `apartment`, `rooms`, `contract_number`, `group` FROM `contracts`'
        );

        $expectedContracts = new Filter($expectedFixture);
        $expectedContracts->addIncludeTables(['contracts']);
        $expectedContracts->setIncludeColumnsForTable('contracts', [
            'status',
            'created_by',
            'building_plot',
            'building_number',

            'floor',
            'apartment',
            'rooms',
            'contract_number',
            'group',
        ]);

        $this->assertTablesEqual($expectedContracts->getTable('contracts'), $contractsTable);
    }

    public function provideProfilesData()
    {
        $profilesFixture = require(__DIR__ . '/fixtures/profiles.inc.php');
        return [
            [
                $profilesFixture,
            ],
        ];
    }
}