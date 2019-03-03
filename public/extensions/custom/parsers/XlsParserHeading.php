<?php

namespace Directus\Custom\Parsers;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception as PhpOfficeException;
use InvalidArgumentException;

/**
 * Class of data heading mapped to Spreadsheet cell.
 */
final class XlsParserHeading
{
    /* @var string Date data type */
    const TYPE_DATE = 'date';

    /* @var string Integer data type */
    const TYPE_INTEGER = 'int';

    /* @var string String data type */
    const TYPE_STRING = 'string';

    /* @var string Boolean data type */
    const TYPE_BOOLEAN = 'bool';

    /* @var string Percentage data type */
    const TYPE_PERCENT = 'percent';

    /* @var string Heading name */
    protected $headingName;

    /* @var string Heading alias */
    protected $headingAlias = null;

    /* @var string Data type */
    protected $dataType = 'string';

    /* @var string[] Mapped spreadsheet cells coordinates */
    protected $cellsCoordinates = [];

    /**
     * Class constructor.
     *
     * @param string      $headingName  Heading name
     * @param string|null $headingAlias Heading alias
     * @param string|null $dataType     Data type
     *
     * @throws InvalidArgumentException
     */
    public function __construct($headingName, $headingAlias = null, $dataType = 'string')
    {
        if (!is_string($headingName)) {
            throw new InvalidArgumentException('\$headingName argument must be string');
        }
        $this->headingName = trim($headingName);

        if (!empty($headingAlias) && !is_string($headingAlias)) {
            throw new InvalidArgumentException('\$headingAlias argument must be string');
        } elseif (!empty($headingAlias)) {
            $this->headingAlias = trim($headingAlias);
        }

        $invalidDataTypeMessage = '\$dataType argument must be one of \'date\', \'int\', \'string\', \'bool\', \'percent\' or NULL';
        if ($dataType !== null && !is_string($dataType)) {
            throw new InvalidArgumentException($invalidDataTypeMessage);
        }

        switch ($dataType) {
            case self::TYPE_DATE:
            case self::TYPE_INTEGER:
            case self::TYPE_BOOLEAN:
            case self::TYPE_PERCENT:
                $this->dataType = $dataType;
                break;
            case self::TYPE_STRING:
            case null:
            case '':
                $this->getDataType = self::TYPE_STRING;
                break;
            default:
                throw new InvalidArgumentException($invalidDataTypeMessage);
        }
    }

    /**
     * Returns heading name.
     *
     * @return string
     */
    public function getHeadingName()
    {
        return $this->headingName;
    }

    /**
     * Returns heading alias.
     *
     * @return string|null
     */
    public function getHeadingAlias()
    {
        return $this->headingAlias;
    }

    /**
     * Returns data type.
     *
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Maps Spreadsheet cell coordinate to heading
     *
     * @param string $cellCoordinate Spreadsheet cell coordinate eg. A1
     *
     * @throws InvalidArgumentException
     */
    public function addCellCoordinate($cellCoordinate)
    {
        $cellCoordinate = (is_string($cellCoordinate)) ? strtoupper($cellCoordinate) : $cellCoordinate;
        try {
            Coordinate::coordinateFromString($cellCoordinate);
        } catch (PhpOfficeException $ex) {
            throw new InvalidArgumentException('\$cellCoordinate argument must be valid cell coordinate, eg. A1');
        }

        $alreadyMapped = false;
        foreach ($this->cellsCoordinates as $pointer) {
            if ($pointer === $cellCoordinate) {
                $alreadyMapped = true;
            }
        }

        if (!$alreadyMapped) {
            $this->cellsCoordinates[] = $cellCoordinate;
        }
    }

    /**
     * Returns mapped Spreadsheet cells coordinates.
     *
     * @return string[]
     */
    public function getCellsCoordinates()
    {
        return $this->cellsCoordinates;
    }

    /**
     * Checks if heading is presented in spreadsheet row.
     *
     * @param string|int $row Row index
     *
     * @return bool
     */
    public function existsInRow($row)
    {
        for ($i = 0; $i < count($this->cellsCoordinates); $i++) {
            $cellCoordinate = $this->cellsCoordinates[$i];
            list($columnIndex, $rowIndex) = Coordinate::coordinateFromString($cellCoordinate);
            if (intval($rowIndex) === intval($row)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if heading is presented in spreadsheet column.
     *
     * @param string|int $column Column index or name
     *
     * @return bool
     */
    public function existsInColumn($column)
    {
        $column = (is_string($column)) ? $column : Coordinate::stringFromColumnIndex($column);
        for ($i = 0; $i < count($this->cellsCoordinates); $i++) {
            $cellCoordinate = $this->cellsCoordinates[$i];
            list($columnIndex, $rowIndex) = Coordinate::coordinateFromString($cellCoordinate);
            if ($columnIndex === $column) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns cell coordinates by row index.
     *
     * @param string|int $row Row index
     *
     * @return string[]
     */
    public function getCellCoordinatesByRow($row)
    {
        return array_values(
            array_filter($this->cellsCoordinates, function($cellCoordinate) use ($row) {
                list($columnIndex, $rowIndex) = Coordinate::coordinateFromString($cellCoordinate);
                return intval($rowIndex) === intval($row);
            })
        );
    }

    /**
     * Returns cell coordinates by column
     *
     * @param string|int $column Column name or index
     *
     * @return string[]
     */
    public function getCellCoordinatesByColumn($column)
    {
        $column = (is_string($column)) ? $column : Coordinate::stringFromColumnIndex($column);
        return array_values(
            array_filter($this->cellsCoordinates, function($cellCoordinate) use ($column) {
                list($columnIndex, $rowIndex) = Coordinate::coordinateFromString($cellCoordinate);
                return $columnIndex === $column;
            })
        );
    }
}
