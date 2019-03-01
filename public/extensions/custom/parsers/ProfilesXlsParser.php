<?php

namespace Directus\Custom\Parsers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProfilesXlsParser
{
    const TYPE_DATE = 'date';
    const TYPE_INTEGER = 'int';
    const TYPE_STRING = 'string';

    const HEADER_MAPPING = [
        'updated_date' => [
            'field' => 'תאריך עדכון',
            'type' => self::TYPE_DATE,
        ],
        'contract_number' => [
            'field' => 'מספר חוזה',
            'type' => self::TYPE_STRING,
        ],
        'group_name' => [
            'field' => 'קבוצה',
            'type' => self::TYPE_STRING,
        ],
        'fullname' => [
            'field' => 'שם רוכש',
            'type' => self::TYPE_STRING,
        ],
        'passport' => [
            'field' => 'מ.ז.',
            'type' => self::TYPE_STRING,
        ],
        'phone_1' => [
            'field' => 'טלפון 1',
            'type' => self::TYPE_STRING,
        ],
        'phone_2' => [
            'field' => 'טלפון 2',
            'type' => self::TYPE_STRING,
        ],
        'email' => [
            'field' => 'כתובת מייל',
            'type' => self::TYPE_STRING,
        ],
        'home_address' => [
            'field' => 'כתובת',
            'type' => self::TYPE_STRING,
        ],
        'building_plot' => [
            'field' => 'מגרש',
            'type' => self::TYPE_STRING,
        ],
        'building_number' => [
            'field' => 'מספר בנין',
            'type' => self::TYPE_STRING,
        ],
        'apartment' => [
            'field' => 'מספר דירה',
            'type' => self::TYPE_STRING,
        ],
        'floor' => [
            'field' => 'קומה',
            'type' => self::TYPE_STRING,
        ],
        'rooms' => [
            'field' => 'מספר חדרים',
            'type' => self::TYPE_STRING,
        ],
    ];

    /**
     * Parse spreadsheet data.
     *
     * @param string $filePath path to file
     *
     * @return array
     */
    public static function parse($filePath)
    {
        $result = [];
        $hebrewHeadings = array_column(self::HEADER_MAPPING, 'field');

        $xls = IOFactory::load($filePath);
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        // search headings
        $headings = [];
        $cIterator = $sheet->getColumnIterator();
        $rIterator = $sheet->getRowIterator();
        $headingRow = null;
        foreach ($cIterator as $column) {
            $rIterator->rewind();
            $headingFound = false;
            while (!$headingFound && $rIterator->valid()) {
                $row = $rIterator->current();
                $cell = $sheet->getCell($column->getColumnIndex() . '' . $row->getRowIndex());
                if ($cell && in_array($cell->getValue(), $hebrewHeadings, true)) {
                    foreach(self::HEADER_MAPPING as $key => $headItem) {
                        if ($headItem['field'] === $cell->getValue()) {
                            $headings[$key] = [
                                'column' => $column->getColumnIndex(),
                                'row' => $row->getRowIndex(),
                                'cell' => $cell->getCoordinate(),
                                'dataType' => $headItem['type'],
                            ];
                        }
                    }

                    $headingFound = true;
                    // assume that lowest row index is heading
                    $headingRow = ($headingRow)
                        ? min($headingRow, $row->getRowIndex())
                        : $row->getRowIndex();
                }
                $rIterator->next();
            }
        }

        if (!empty($headings)) {
            // iterate through data
            $rIterator->resetStart($headingRow + 1);
            foreach ($rIterator as $row) {
                $record = [];
                $recordIsEmpty = true;

                foreach($headings as $headField => $headItem) {
                    $cell = $sheet->getCell($headItem['column'] . $row->getRowIndex());
                    $value = trim($cell->getValue());
                    $dataType = $headItem['dataType'];

                    if (Date::isDateTime($cell) && $dataType === self::TYPE_DATE) {
                        // datetime value
                        $value = Date::excelToDateTimeObject($cell->getValue())->format('Y-m-d');
                    }

                    if (!empty($value)) {
                        $recordIsEmpty = false;
                        $record[$headField] = $value;
                    } else {
                        $record[$headField] = null;
                    }
                }
                if (!$recordIsEmpty) {
                    $result[] = $record;
                }
            }
        }

        return $result;
    }
}
