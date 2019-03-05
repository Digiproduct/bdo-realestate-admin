<?php

namespace Directus\Custom\Database;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use Directus\Application\Application;
use Directus\Database\SchemaService;
use Directus\Database\TableGateway\BaseTableGateway;
use Directus\Database\TableGatewayFactory;
use Directus\Permissions\Acl;
use PDO;

abstract class DatabaseTestCase extends TestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    static protected $container = null;

    static public function setupBeforeClass() {
        parent::setupBeforeClass();

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        if (self::$container === null) {
            $app = new Application(__DIR__, self::getAppConfig());
            $container = $app->getContainer();
            self::$container = $container;

            $acl = new Acl([
                'directus_users' => [[
                    'role' => 1,
                ]],
            ]);
            $acl->setUserId(1);
            $container->set('acl', $acl);
            SchemaService::setAclInstance($acl);
            SchemaService::setConnectionInstance($container->get('database'));
            SchemaService::setConfig($container->get('config'));
            BaseTableGateway::setHookEmitter($container->get('hook_emitter'));
            BaseTableGateway::setContainer($container);
            TableGatewayFactory::setContainer($container);
        }
    }

    /**
     * @return Connection
     */
    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO(
                    "mysql:dbname={$GLOBALS['DB_DBNAME']};host={$GLOBALS['DB_HOST']};port={$GLOBALS['DB_PORT']}",
                    $GLOBALS['DB_USER'],
                    $GLOBALS['DB_PASSWD']
                );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    final static protected function getAppConfig()
    {
        $config = [
            'app' => [
                'env' => 'development',
                'timezone' => 'America/New_York',
            ],

            'database' => [
                'type' => 'mysql',
                'host' => $GLOBALS['DB_HOST'],
                'port' => $GLOBALS['DB_PORT'],
                'name' => $GLOBALS['DB_DBNAME'],
                'username' => $GLOBALS['DB_USER'],
                'password' => $GLOBALS['DB_PASSWD'],
                'engine' => 'InnoDB',
                'charset' => 'utf8mb4',
                // When using unix socket to connect to the database the host attribute should be removed
                'socket' => '/Applications/MAMP/tmp/mysql/mysql.sock',
                // 'socket' => '',
            ],

            'cache' => [
                'enabled' => false,
                'response_ttl' => 3600, // seconds
            ],

            'storage' => [
                'adapter' => 'local',
                // The storage root is the directus root directory.
                // All path are relative to the storage root when the path is not starting with a forward slash.
                // By default the uploads directory is located at the directus public root
                // An absolute path can be used as alternative.
                'root' => 'public/uploads/_/originals',
                // This is the url where all the media will be pointing to
                // here is where Directus will assume all assets will be accessed
                // Ex: (yourdomain)/uploads/_/originals
                'root_url' => '/uploads/_/originals',
                // Same as "root", but for the thumbnails
                'thumb_root' => 'public/uploads/_/thumbnails',
            ],

            'mail' => [
                'default' => [
                    'transport' => 'sendmail',
                    'from' => 'admin@example.com'
                ],
            ],
        ];


        return $config;
    }
}