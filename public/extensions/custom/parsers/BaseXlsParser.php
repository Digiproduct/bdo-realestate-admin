<?php

namespace Directus\Custom\Parsers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;
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
     * @param XlsParserHeadings[] $xlsParserHeadings Array with headings
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
     * @param string $filePath Path to file
     * @param array  $options  Assoc array with options
     *
     * @return array
     */
    public function parse($filePath, $options = null)
    {
        $result = [];

        // prepare parsing options
        $options = (is_array($options)) ? $options : [];
        $options = array_merge([
            'spreadsheetIndex' => 0,
            'parseHiddenCells' => false,
            'parseCollapsedCells' => false,
        ], $options);

        $xls = IOFactory::load($filePath);
        $xls->setActiveSheetIndex($options['spreadsheetIndex']);
        $sheet = $xls->getActiveSheet();

        // clear hidden and collapsed columns/rows
        if ($options['parseHiddenCells'] === false) {
            $this->clearHiddenColumnsAndRows($sheet);
        }

        if ($options['parseCollapsedCells'] === false) {
            $this->clearCollapsedColumnsAndRows($sheet);
        }

        // search headings
        $this->findHeadingsInSpreadsheet($this->headings, $sheet);

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
                    switch ($dataType) {
                        case XlsParserHeading::TYPE_DATE:
                            if (Date::isDateTime($cell)) {
                                $dateTime = Date::excelToDateTimeObject($cell->getValue());
                                $value = $dateTime->format('Y-m-d');
                                break;
                            }
                            $value = trim($cell->getValue());
                            break;
                        case XlsParserHeading::TYPE_BOOLEAN:
                            $value = !empty(trim($cell->getValue()));
                            break;
                        default:
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
     * @param XlsParserHeading[] $xlsParserHeadings Array with targeted headings
     * @param Worksheet          $spreadsheet       Target spreadsheet
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
    }

    /**
     * Returns all headings names as flat array.
     *
     * @param XlsParserHeading[] $xlsParserHeadings Array with targeted headings
     *
     * @return string[]
     */
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

    /**
     * Returns all headings aliases as flat array.
     *
     * @param XlsParserHeading[] $xlsParserHeadings Array with targeted headings
     *
     * @return string[]
     */
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

    /**
     * Returns row indexes where headings exists.
     * Indexes will be arranged from lowest to highest
     *
     * @param XlsParserHeading[] $xlsParserHeadings Array with targeted headings
     *
     * @return int[]
     */
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

    /**
     * Clears cells in hidden columns and rows.
     *
     * @param Worksheet $spreadsheet Target spreadsheet
     */
    protected function clearHiddenColumnsAndRows($spreadsheet)
    {
        $rowIndex = 1;
        $highestRow = $spreadsheet->getHighestDataRow();
        while ($highestRow >= $rowIndex) {
            $rowDimension = $spreadsheet->getRowDimension($rowIndex);
            if (!$rowDimension->getVisible()) {
                $row = new Row($spreadsheet, $rowIndex);
                $iterator = $row->getCellIterator();
                foreach ($iterator as $cell) {
                    $cell->setValue(NULL);
                }
            }
            $rowIndex++;
        }

        $columnIndex = 1;
        $highestColumn = Coordinate::columnIndexFromString($spreadsheet->getHighestDataColumn());
        while ($highestColumn >= $columnIndex) {
            $columnLiteral = Coordinate::stringFromColumnIndex($columnIndex);
            $columnDimension = $spreadsheet->getColumnDimension($columnLiteral);
            if (!$columnDimension->getVisible()) {
                $column = new Column($spreadsheet, $columnLiteral);
                $iterator = $column->getCellIterator();
                foreach ($iterator as $cell) {
                    $cell->setValue(NULL);
                }
            }
            $columnIndex++;
        }
    }

    /**
     * Clears cells in collapsed columns and rows.
     *
     * @param Worksheet $spreadsheet Target spreadsheet
     */
    protected function clearCollapsedColumnsAndRows($spreadsheet)
    {

        $rowIndex = 1;
        $highestRow = $spreadsheet->getHighestDataRow();
        while ($highestRow >= $rowIndex) {
            $rowDimension = $spreadsheet->getRowDimension($rowIndex);
            if ($rowDimension->getCollapsed()) {
                $row = new Row($spreadsheet, $rowIndex);
                $iterator = $row->getCellIterator();
                foreach ($iterator as $cell) {
                    $cell->setValue(NULL);
                }
            }
            $rowIndex++;
        }

        $columnIndex = 1;
        $highestColumn = Coordinate::columnIndexFromString($spreadsheet->getHighestDataColumn());
        while ($highestColumn >= $columnIndex) {
            $columnLiteral = Coordinate::stringFromColumnIndex($columnIndex);
            $columnDimension = $spreadsheet->getColumnDimension($columnLiteral);
            if ($columnDimension->getCollapsed()) {
                $column = new Column($spreadsheet, $columnLiteral);
                $iterator = $column->getCellIterator();
                foreach ($iterator as $cell) {
                    $cell->setValue(NULL);
                }
            }
            $columnIndex++;
        }
    }
}
