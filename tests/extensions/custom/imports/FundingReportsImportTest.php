<?php

namespace Directus\Custom\Imports;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\DataSet\Filter;
use Directus\Custom\Database\DatabaseTestCase;
use Directus\Custom\Imports\FundingReportsImport;

/**
 * @coversDefaultClass \Directus\Custom\Imports\FundingReportsImport
 */
class FundingReportsImportTest extends DatabaseTestCase
{

    /**
     * @return IDataSet
     */
    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . '/files/funding_setup.xml');
    }

    /**
     * @covers ::execute
     * @dataProvider provideReportsData
     */
    public function testExecute($reportsData)
    {
        $expectedFixture = $this->createMySQLXMLDataSet(__DIR__ . '/files/funding_expected.xml');

        $import = new FundingReportsImport(self::$container);
        $import->execute($reportsData);

        // assert funding reports data tables
        $actualReportsTable = $this->getConnection()->createQueryTable(
            'funding_reports', 'SELECT `id`, `status`, `created_by`, `contract_number`, `date_range`, `total_debit`, `total_credit`, `total_balance`, `updated_date` FROM `funding_reports`'
        );

        $expectedReportsDataSet = new Filter($expectedFixture);
        $expectedReportsDataSet->setIncludeColumnsForTable('funding_reports', [
            'id',
            'status',
            'created_by',
            'contract_number',
            'date_range',
            'total_debit',
            'total_credit',
            'total_balance',
            'updated_date',
        ]);

        $this->assertTablesEqual($expectedReportsDataSet->getTable('funding_reports'), $actualReportsTable);

        // assert transactions table
        $actualTransactionsTable = $this->getConnection()->createQueryTable(
            'transactions', 'SELECT `id`, `status`, `created_by`, `funding_report`, `title`, `move`, `ration`, `counter_account`, `date_1`, `date_2`, `reference_1`, `reference_2`, `details`, `debit`, `credit`, `balance` FROM `transactions`'
        );

        $expectedTransactionsDataSet = new Filter($expectedFixture);
        $expectedTransactionsDataSet->setIncludeColumnsForTable('transactions', [
            'id',
            'status',
            'created_by',
            'funding_report',
            'title',
            'move',
            'ration',
            'counter_account',
            'date_1',
            'date_2',
            'reference_1',
            'reference_2',
            'details',
            'debit',
            'credit',
            'balance',
        ]);

        $this->assertTablesEqual($expectedTransactionsDataSet->getTable('transactions'), $actualTransactionsTable);
    }

    public function provideReportsData()
    {
        return [
            [
                [
                    [
                        'contract_number' => '702002',// 12
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 14,
                                'move' => 28,
                                'ration' => 2,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 432000,
                                'balance' => 432000,
                            ],
                            [
                                'title' => 180,
                                'move' => 360,
                                'ration' => 3,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => -432000,
                                'balance' => 0,
                            ],
                            [
                                'title' => 376,
                                'move' => 752,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 432000,
                                'balance' => 432000,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 432000,
                        'total_balance' => 432000,
                        'updated_date' => '2019-01-16',
                    ],
                    [
                        'contract_number' => '75006',// 8
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 21,
                                'move' => 42,
                                'ration' => 2,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 334921,
                                'balance' => 334921,
                            ],
                            [
                                'title' => 187,
                                'move' => 374,
                                'ration' => 3,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => -334921,
                                'balance' => 0,
                            ],
                            [
                                'title' => 383,
                                'move' => 766,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 334921,
                                'balance' => 334921,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 334921,
                        'total_balance' => 334921,
                        'updated_date' => '2019-01-16',
                    ],
                    [
                        'contract_number' => '703001', // 5
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 2,
                                'move' => 4,
                                'ration' => 2,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 336045,
                                'balance' => 336045,
                            ],
                            [
                                'title' => 168,
                                'move' => 336,
                                'ration' => 3,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => -336045,
                                'balance' => 0,
                            ],
                            [
                                'title' => 364,
                                'move' => 728,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 336045,
                                'balance' => 336045,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 336045,
                        'total_balance' => 336045,
                        'updated_date' => '2019-01-16',
                    ],
                    [
                        'contract_number' => '804019',// 33
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 411,
                                'move' => 822,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 176000,
                                'balance' => 176000,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 176000,
                        'total_balance' => 176000,
                        'updated_date' => '2019-01-16',
                    ],
                    [
                        'contract_number' => '804002',// 22
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 35,
                                'move' => 70,
                                'ration' => 2,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 380000,
                                'balance' => 380000,
                            ],
                            [
                                'title' => 201,
                                'move' => 402,
                                'ration' => 3,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => -380000,
                                'balance' => 0,
                            ],
                            [
                                'title' => 397,
                                'move' => 794,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 380000,
                                'balance' => 380000,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 380000,
                        'total_balance' => 380000,
                        'updated_date' => '2019-01-16',
                    ],
                    [
                        'contract_number' => '804010',// 27
                        'date_range' => 'תאריך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך ערך מ..עד ‎01/01/1980  >> 31/12/2029 ; תאריך 3 מ..עד ‎01/01/1980  >> 31/12/2029',
                        'transactions' => [
                            [
                                'title' => 28,
                                'move' => 56,
                                'ration' => 2,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 220000,
                                'balance' => 220000,
                            ],
                            [
                                'title' => 194,
                                'move' => 388,
                                'ration' => 3,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => -220000,
                                'balance' => 0,
                            ],
                            [
                                'title' => 390,
                                'move' => 780,
                                'ration' => 5,
                                'counter_account' => '999998',
                                'date_1' => '2018-09-06',
                                'date_2' => '2018-09-06',
                                'reference_1' => 0,
                                'reference_2' => 0,
                                'details' => 'יתרת פתיחה 6.9.18',
                                'debit' => null,
                                'credit' => 220000,
                                'balance' => 220000,
                            ],
                            [
                                'title' => 143,
                                'move' => 286,
                                'ration' => 9999,
                                'counter_account' => '100001',
                                'date_1' => '2018-12-09',
                                'date_2' => '2018-12-09',
                                'reference_1' => null,
                                'reference_2' => 10005,
                                'details' => 'אלתר חמו יפעת',
                                'debit' => null,
                                'credit' => 172551,
                                'balance' => 392551,
                            ],
                            [
                                'title' => 166,
                                'move' => 332,
                                'ration' => 9999,
                                'counter_account' => '100001',
                                'date_1' => '2018-12-13',
                                'date_2' => '2018-12-13',
                                'reference_1' => null,
                                'reference_2' => 10011,
                                'details' => 'פעימה 2 - אלתר',
                                'debit' => null,
                                'credit' => 173383,
                                'balance' => 565934,
                            ],
                        ],
                        'total_debit' => 0,
                        'total_credit' => 565934,
                        'total_balance' => 565934,
                        'updated_date' => '2019-01-16',
                    ],
                ],
            ],
        ];
    }
}
