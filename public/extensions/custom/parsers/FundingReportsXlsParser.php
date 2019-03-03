<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\BaseXlsParser;
use Directus\Custom\Parsers\XlsParserHeading;
use DateTime;

final class FundingReportsXlsParser extends BaseXlsParser
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        $contractNumberHeading = new XlsParserHeading('contract_number');
        // we know that contract number is always in B column
        $contractNumberHeading->addCellCoordinate('B4');
        parent::__construct([
            $contractNumberHeading,
            new XlsParserHeading('title', 'כותרת', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('move', 'תנועה', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('ration', 'מנה', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('counter_account', 'ח-ן נגדי'),
            new XlsParserHeading('date_1', 'ת.אסמכ', XlsParserHeading::TYPE_DATE),
            new XlsParserHeading('date_2', 'ת.ערך', XlsParserHeading::TYPE_DATE),
            new XlsParserHeading('reference_1', "אסמ'", XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('reference_2', "אסמ'2", XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('details', 'פרטים'),
            new XlsParserHeading('debit', ' חובה / זכות (שקל) חובה', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('credit', '  חובה / זכות (שקל) זכות'),
            new XlsParserHeading('balance', 'יתרה (שקל)', XlsParserHeading::TYPE_INTEGER),
        ]);
    }

    public function parse($filePath, $options = null)
    {
        $options = [
            'spreadsheetIndex' => 0,
            'parseHiddenCells' => true,
            'parseCollapsedCells' => true,
        ];

        $sheet = $this->loadSpreadsheet($filePath, $options['spreadsheetIndex']);
        $updatedDateValue = $sheet->getCell('Q1')->getValue();
        $dateRange = $sheet->getCell('A3')->getvalue();
        $updateDate = DateTime::createFromFormat('d/m/Y H:i', $updatedDateValue);

        $records = parent::parse($filePath, $options);

        $isDebitCellValue = function($value) {
            // eg. 0.00   חובה
            return preg_match('/חובה/', $value) === 1;
        };

        $isCreditCellValue = function($value) {
            // eg. 334,921.00    זכות
            return preg_match('/זכות/', $value) === 1;
        };

        $isBalanceCellValue = function($value) {
            // eg. 334,921.00  הפרש
            return preg_match('/הפרש/', $value) === 1;
        };

        $parseInt = function($value) {
            return intval(preg_replace('/[^0-9\.\-]/', '', $value));
        };

        $result = [];
        $report = [
            'contract_number' => null,
            'transactions' => [],
            'updated_date' => $updateDate->format('Y-m-d'),
            'date_range' => $dateRange,
        ];

        foreach ($records as $item) {
            $contractNumber = $item['contract_number'];

            $title = $item['title'];
            $move = $item['move'];
            $ration = $item['ration'];
            $counterAccount = $item['counter_account'];
            $date1 = $item['date_1'];
            $date2 = $item['date_2'];
            $reference1 = $item['reference_1'];
            $reference2 = $item['reference_2'];
            $details = $item['details'];

            $debit = $item['debit'];
            $credit = $item['credit'];
            $balance = $item['balance'];

            if (!empty($contractNumber) && $report['contract_number'] === null) {
                $report['contract_number'] = $contractNumber;
            } elseif (!empty($contractNumber) &&  $contractNumber !== $report['contract_number']) {
                // new report started, save the old one
                $result[] = $report;
                $report = [
                    'contract_number' => $contractNumber,
                    'transactions' => [],
                    'updated_date' => $updateDate->format('Y-m-d'),
                    'date_range' => $dateRange,
                ];
            }

            if ($counterAccount !== null) {
                $report['transactions'][] = [
                    'title' => $title,
                    'move' => $move,
                    'ration' => $ration,
                    'counter_account' => $counterAccount,
                    'date_1' => $date1,
                    'date_2' => $date2,
                    'reference_1' => $reference1,
                    'reference_2' => $reference2,
                    'details' => $details,
                    'debit' => $debit,
                    'credit' => $credit,
                    'balance' => $balance,
                ];
            }

            if ($isDebitCellValue($credit) && !array_key_exists('total_debit', $report)) {
                $report['total_debit'] = $parseInt($credit);
            }

            if ($isCreditCellValue($credit) && !array_key_exists('total_credit', $report)) {
                $report['total_credit'] = $parseInt($credit);
            }

            if ($isBalanceCellValue($credit) && !array_key_exists('total_balance', $report)) {
                $report['total_balance'] = $parseInt($credit);
            }
        }

        if (count($result) && $result[count($result) - 1]['contract_number'] !== $report['contract_number']) {
            $result[] = $report;
        }

        return $result;
    }
}
