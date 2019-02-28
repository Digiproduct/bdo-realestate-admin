<?php

namespace Directus\Custom\Parsers;

use League\Csv\Reader;
use League\Csv\CharsetConverter;
use DateTime;
use Exception;

class ProfilesCsvParser
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
     * Parse CSV data.
     *
     * @param string $filePath
     *
     * @return array
     */
    public static function parse($filePath)
    {
        $result = [];
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $input_bom = $csv->getInputBOM();
        switch ($input_bom) {
            case Reader::BOM_UTF16_LE:
            case Reader::BOM_UTF16_BE:
                CharsetConverter::addTo($csv, 'utf-16', 'utf-8');
                break;
            case Reader::BOM_UTF32_BE:
            case Reader::BOM_UTF32_LE:
                CharsetConverter::addTo($csv, 'utf-32', 'utf-8');
                break;
            case Reader::BOM_UTF8:
                // do nothing, already in utf8
                break;
            default:
                // CharsetConverter::addTo($csv, 'ISO-8859-8', 'utf-8');
        }

        // use anonymous function instead of external for static method
        $handleDateValue = function($dateStr) {
            $outputDate = $dateStr;
            try {
                $date = new DateTime($dateStr);
                $outputDate = $date->format('Y-m-d');
            } catch (Exception $e) {
                $date = DateTime::createFromFormat('d/m/y', $dateStr);
                if ($date) {
                    $outputDate = $date->format('Y-m-d');
                }
            }

            return $outputDate;
        };

        $headers = array_map(function($column) {
            $column = trim($column);
            foreach (self::HEADER_MAPPING as $key => $col) {
                if ($col['field'] === $column) {
                    $column = $key;
                }
            }
            return $column;
        }, $csv->getHeader());

        foreach ($csv->getRecords($headers) as $record) {

            $row = [];
            $rowIsEmpty = true;

            $columns = array_keys(self::HEADER_MAPPING);
            foreach (self::HEADER_MAPPING as $field => $col) {
                $hasKey = array_key_exists($field, $record);
                $dataType = $col['type'];
                $value = ($hasKey) ? trim($record[$field]) : null;

                if ($value) {
                    switch ($dataType) {
                        case self::TYPE_DATE:
                            $value = $handleDateValue($value);
                            break;
                        case self::TYPE_STRING:
                        default:
                            // do nothing, already string
                    }
                }

                if ($hasKey && !empty($value)) {
                    $rowIsEmpty = false;
                    $row[$field] = $value;
                } else {
                    $row[$field] = null;
                }
            }
            if (!$rowIsEmpty) {
                $result[] = $row;
            }
        }

        return $result;
    }
}
