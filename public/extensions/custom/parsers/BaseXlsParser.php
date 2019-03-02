<?php

namespace Directus\Custom\Parsers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception as PhpOfficeException;
use Directus\Custom\Parsers\XlsParserHeading;
use InvalidArgumentException;

class BaseXlsParser
{

    protected $headings;

    /**
     * Class constructor
     *
     * @param XlsParserHeadings[] $xlsParserHeadings
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $xlsParserHeadings)
    {
        if (!is_array($xlsParserHeadings)) {
            throw new InvalidArgumentException('\$xlsParserHeadings argument must be array of XlsParserHeadings');
        }

        foreach ($xlsParserHeadings as $heading) {
            if ($heading instanceof XlsParserHeading === false) {
                throw new InvalidArgumentException('Each element of \$xlsParserHeadings must be instance of XlsParserHeadings');
            }
        }

        if (!count($xlsParserHeadings)) {
            throw new InvalidArgumentException('\$xlsParserHeadings argument cannot be empty array');
        }
        $this->headings = $xlsParserHeadings;
    }

    /**
     * Parse spreadsheet data.
     *
     * @param string $filePath path to file
     *
     * @return array
     */
    public function parse($filePath, $spreadsheetIndex = 0)
    {
        $result = [];

        $xls = IOFactory::load($filePath);
        $xls->setActiveSheetIndex($spreadsheetIndex);
        $sheet = $xls->getActiveSheet();

        // search headings
        $this->headings = $this->findHeadingsInSpreadsheet($this->headings, $sheet);

        // find rows where headings presented
        $headingRows = $this->getHeadingRows($this->headings);

        for ($i = 0; $i<count($headingRows); $i++) {
            $headingRowIndex = $headingRows[$i];
            $startRowIndex = $headingRowIndex + 1;
            $endRowIndex = (array_key_exists($i + 1, $headingRows)) ? $headingRows[$i + 1] : null;
            $currentHeadings = array_filter($this->headings, function($heading) use ($headingRowIndex) {
                return $heading->existsInRow($headingRowIndex);
            });

            foreach ($sheet->getRowIterator($startRowIndex, $endRowIndex) as $row) {
                $record = [];
                $recordIsEmpty = true;

                foreach ($currentHeadings as $heading) {
                    $dataKey = $heading->getHeadingName();
                    $dataType = $heading->getDataType();
                    $cellCoordinate = $heading->getCellCoordinatesByRow($headingRowIndex)[0];
                    list($column) = Coordinate::coordinateFromString($cellCoordinate);
                    $columnIndex = Coordinate::columnIndexFromString($column);
                    $cell = $sheet->getCellByColumnAndRow($columnIndex, $row->getRowIndex());
                    $value = null;
                    if (Date::isDateTime($cell) && $dataType === XlsParserHeading::TYPE_DATE) {
                        // datetime value
                        $value = Date::excelToDateTimeObject($cell->getValue())->format('Y-m-d');
                    } else {
                        $value = trim($cell->getValue());
                    }

                    if (!empty($value)) {
                        $recordIsEmpty = false;
                        $record[$dataKey] = $value;
                    } else {
                        $record[$dataKey] = null;
                    }
                }

                if (!$recordIsEmpty) {
                    $result[] = $record;
                }
            }
        }

        return $result;
    }

    /**
     * Finds headings in spreadsheet cells.
     *
     * @param XlsParserHeading[] Array with targeted headings
     * @param Worksheet          Target spreadsheet
     *
     * @return XlsParserHeading[]
     */
    protected function findHeadingsInSpreadsheet(array $xlsParserHeadings, $spreadsheet)
    {
        $headingNames = $this->getAllHeadingNames($xlsParserHeadings);
        $headingAliases = $this->getAllHeadingAliases($xlsParserHeadings);

        foreach ($spreadsheet->getColumnIterator() as $column) {
            $cellIterator = $column->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(TRUE);
            foreach ($cellIterator as $cell) {
                $value = $cell->getValue();
                if (in_array($value, $headingNames, true) || in_array($value, $headingAliases, true)) {
                    foreach($xlsParserHeadings as $heading) {
                        if ($heading->getHeadingName() === $value || $heading->getHeadingAlias() === $value) {
                            $heading->addCellCoordinate($cell->getCoordinate());
                        }
                    }
                }
            }
        }

        return $xlsParserHeadings;
    }

    protected function getAllHeadingNames(array $xlsParserHeadings)
    {
        $headingNames = [];
        foreach ($xlsParserHeadings as $heading) {
            if (!in_array($heading->getHeadingName(), $headingNames, true)) {
                $headingNames[] = $heading->getHeadingName();
            }
        }

        return $headingNames;
    }

    protected function getAllHeadingAliases(array $xlsParserHeadings)
    {
        $headingAliases = [];
        foreach ($xlsParserHeadings as $heading) {
            $alias = $heading->getHeadingAlias();
            if ($alias && !in_array($alias, $headingAliases, true)) {
                $headingAliases[] = $alias;
            }
        }

        return $headingAliases;
    }

    protected function getHeadingRows(array $xlsParserHeadings)
    {
        $headingRows = [];

        foreach ($xlsParserHeadings as $heading) {
            foreach ($heading->getCellsCoordinates() as $coordinate) {
                try {
                    list($column, $row) = Coordinate::coordinateFromString($coordinate);
                    if (!in_array($row, $headingRows)) {
                        $headingRows[] = $row;
                    }
                } catch (PhpOfficeException $ex) {
                    // invalid cell coordinate, just skip it
                }
            }
        }
        sort($headingRows);

        return $headingRows;
    }
}
