<?php

namespace Directus\Custom\Parsers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
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
                    $headingName = $heading->getHeadingName();
                    $headingCellCoordinate = $heading->getCellCoordinatesByRow($headingRowIndex)[0];
                    list($column) = Coordinate::coordinateFromString($headingCellCoordinate);
                    $cellCoordinate = $column . $row->getRowIndex();
                    $cellCollapsed = $this->isRowCollapsed($sheet, $row->getRowIndex())
                        || $this->isColumnCollapsed($sheet, $column);
                    $cellVisible = $this->isRowVisible($sheet, $row->getRowIndex())
                        && $this->isColumnVisible($sheet, $column);

                    if (!$cellCollapsed && $cellVisible) {
                        // process not collapsed and visible cells only
                        $value = $this->cellValueToHeadingType($sheet, $cellCoordinate, $heading);
                        if (!empty($value)) {
                            $recordIsEmpty = false;
                            $record[$headingName] = $value;
                        } else {
                            $record[$headingName] = null;
                        }
                    }
                }

                if (!$recordIsEmpty) {
                    $result[] = $this->postProcessRecord($record);
                }
            }
        }

        return $result;
    }

    /**
     * Converts cell value to heading type.
     *
     * @param Worksheet        $sheet            Spreadsheet
     * @param string           $cellCoordinate   Cell coordinate eg. A1
     * @param XlsParserHeading $xlsParserHeading Heading
     *
     * @return string|int|boolean
     */
    protected function cellValueToHeadingType($sheet, $cellCoordinate, $xlsParserHeading)
    {
        $value = null;
        if (!$sheet->cellExists($cellCoordinate)) {
            return $value;
        }

        $dataType = $xlsParserHeading->getDataType();
        $cell = $sheet->getCell($cellCoordinate);

        switch ($dataType) {
            case XlsParserHeading::TYPE_DATE:
                if (Date::isDateTime($cell)) {
                    $excelDateValue = ($cell->isFormula) ? trim($cell->getCalculatedValue()) : $cell->getValue();
                    $dateTime = Date::excelToDateTimeObject($excelDateValue);
                    $value = $dateTime->format('Y-m-d');
                    break;
                }
                $value = ($cell->isFormula) ? trim($cell->getCalculatedValue()) : trim($cell->getValue());
                break;
            case XlsParserHeading::TYPE_BOOLEAN:
                $value = !empty(trim($cell->getValue()));
                break;
            case XlsParserHeading::TYPE_PERCENT:
                $numberFormat = $cell->getStyle()->getNumberFormat();
                $numberFormatCode = $numberFormat->getFormatCode();
                if ($numberFormatCode === NumberFormat::FORMAT_PERCENTAGE || $numberFormat === NumberFormat::FORMAT_PERCENTAGE_00) {
                    $value = (int) round($cell->getCalculatedValue() * 100, 0);
                    break;
                }
                $value = trim($cell->getCalculatedValue());
                break;
            case XlsParserHeading::TYPE_INTEGER:
                $value = (int) round($cell->getCalculatedValue(), 0);
                break;
            default:
                if ($cell->isFormula()) {
                    $value = trim($cell->getCalculatedValue());
                } else {
                    $value = trim($cell->getValue());
                }
        }

        return $value;
    }

    /**
     * Process each parsed record when needed.
     *
     * @param array $record Record
     *
     * @return array
     */
    protected function postProcessRecord($record)
    {
        return $record;
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
            foreach ($cellIterator as $cell) {
                $value = trim(strval($cell->getValue()));
                if (in_array($value, $headingNames, true) || in_array($value, $headingAliases, true)) {
                    foreach($xlsParserHeadings as $heading) {
                        $headingName = $heading->getHeadingName();
                        $headingAlias = ($heading->getHeadingAlias()) ? $heading->getHeadingAlias() : null;
                        if ($headingName === $value || $headingAlias === $value) {
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
    final protected function clearHiddenColumnsAndRows($spreadsheet)
    {
        $rowIndex = 1;
        $highestRow = $spreadsheet->getHighestDataRow();
        while ($highestRow >= $rowIndex) {
            if (!$this->isRowVisible($spreadsheet, $rowIndex)) {
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
            if (!$this->isColumnVisible($spreadsheet, $columnIndex)) {
                $columnLiteral = Coordinate::stringFromColumnIndex($columnIndex);
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
    final protected function clearCollapsedColumnsAndRows($spreadsheet)
    {

        $rowIndex = 1;
        $highestRow = $spreadsheet->getHighestDataRow();
        while ($highestRow >= $rowIndex) {
            if ($this->isRowCollapsed($spreadsheet, $rowIndex)) {
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
            if ($this->isColumnCollapsed($spreadsheet, $columnIndex)) {
                $columnLiteral = Coordinate::stringFromColumnIndex($columnIndex);
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
     * Checks if column is collapsed.
     *
     * @param Worksheet  $sheet       Spreadsheet
     * @param string|int $columnIndex Column index
     *
     * @return bool
     */
    final protected function isColumnCollapsed($sheet, $columnIndex)
    {
        if (is_string($columnIndex)) {
            return $sheet->getColumnDimension($columnIndex, true)->getCollapsed();
        }

        return $sheet->getColumnDimensionByColumn($columnIndex, true)->getCollapsed();
    }

    /**
     * Checks if column is visible.
     *
     * @param Worksheet  $sheet       Spreadsheet
     * @param string|int $columnIndex Column index
     *
     * @return bool
     */
    final protected function isColumnVisible($sheet, $columnIndex)
    {
        if (is_string($columnIndex)) {
            return $sheet->getColumnDimension($columnIndex, true)->getVisible();
        }

        return $sheet->getColumnDimensionByColumn($columnIndex, true)->getVisible();
    }

    /**
     * Checks if row is collapsed.
     *
     * @param Worksheet  $sheet    Spreadsheet
     * @param string|int $rowIndex Row index
     *
     * @return bool
     */
    final protected function isRowCollapsed($sheet, $rowIndex)
    {
        return $sheet->getRowDimension($rowIndex, true)->getCollapsed();
    }

    /**
     * Checks if row is visible.
     *
     * @param Worksheet  $sheet    Spreadsheet
     * @param string|int $rowIndex Row index
     *
     * @return bool
     */
    final protected function isRowVisible($sheet, $rowIndex)
    {
        return $sheet->getRowDimension($rowIndex, true)->getVisible();
    }
}
