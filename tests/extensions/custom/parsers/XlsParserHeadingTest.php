<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\XlsParserHeading;
use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use DateTime;

/**
 * @coversDefaultClass \Directus\Custom\Parsers\XlsParserHeading
 */
class XlsParserHeadingTest extends TestCase
{
    /**
     * @dataProvider provideConstructorGoodArguments
     * @covers ::constructor
     */
    public function testConstructorWithGoodArguments($headingName, $headingAlias, $dataType)
    {
        $heading = new XlsParserHeading($headingName, $headingAlias, $dataType);
        $this->assertEquals($headingName, $heading->getHeadingName());
    }

    /**
     * @dataProvider provideConstructorBadArguments
     * @covers ::constructor
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithBadAgruments($headingName, $headingAlias, $dataType)
    {
        $heading = new XlsParserHeading($headingName, $headingAlias, $dataType);
    }

    /**
     * @dataProvider provideHeadingNames
     * @covers ::getHeadingName
     */
    public function testGetHeadingName($headingName, $expectedHeadingName)
    {
        $heading = new XlsParserHeading($headingName);
        $this->assertEquals($expectedHeadingName, $heading->getHeadingName());
    }

    /**
     * @dataProvider provideAliases
     * @covers ::getHeadingAlias
     */
    public function testGetHeadingAlias($alias, $expectedAlias)
    {
        $heading = new XlsParserHeading('title', $alias);
        $this->assertEquals($expectedAlias, $heading->getHeadingAlias());
    }

    /**
     * @dataProvider provideDataTypes
     * @covers ::getDataType
     */
    public function testGetDataType($dataType, $expectedDataType)
    {
        $heading = new XlsParserHeading('title', null, $dataType);
        $this->assertEquals($expectedDataType, $heading->getDataType());
    }

    /**
     * @dataProvider provideGoodSpreadsheetCells
     * @covers ::addCellCoordinate
     */
    public function testAddCellCoordinateWithGoodArguments($cells, $expectedCellsLength)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }
        $this->assertCount($expectedCellsLength, $heading->getCellsCoordinates());
        $this->assertEquals($cells[0], $heading->getCellsCoordinates()[0]);

        // add all cells again and check that result didn't change
        foreach ($cells as $cellItemDuplicate) {
            $heading->addCellCoordinate($cellItemDuplicate);
        }
        $this->assertCount($expectedCellsLength, $heading->getCellsCoordinates());
        $this->assertEquals($cells[0], $heading->getCellsCoordinates()[0]);
    }

    /**
     * @dataProvider provideBadSpreadsheetCells
     * @covers ::addCellCoordinate
     * @expectedException \InvalidArgumentException
     */
    public function testAddCellCoordinateWithBadArguments($cell)
    {
        $heading = new XlsParserHeading('title');
        $heading->addCellCoordinate($cell);
    }

    /**
     * @dataProvider provideGoodSpreadsheetCells
     * @covers ::getCellsCoordinates
     */
    public function testGetCellsCoordinates($cells)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }
        $cellCoordinates = $heading->getCellsCoordinates();
        $this->assertInternalType('array', $cellCoordinates);
        foreach ($cellCoordinates as $pointer) {
            $this->assertInternalType('string', $pointer);
            $coor = Coordinate::coordinateFromString($pointer);
            $this->assertInternalType('array', $coor);
        }
    }

    /**
     * @dataProvider provideCellsForRowSearch
     * @covers ::existsInRow
     */
    public function testExistsInRow($cells, $targetRow, $expectedBoolean, $expectedArray)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }

        $this->assertEquals($expectedBoolean, $heading->existsInRow($targetRow));
    }

    /**
     * @dataProvider provideCellsForColumnSearch
     * @covers ::existsInColumn
     */
    public function testExistsInColumn($cells, $targetColumn, $expectedBoolean, $expectedArray)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }

        $this->assertEquals($expectedBoolean, $heading->existsInColumn($targetColumn));
    }

    /**
     * @dataProvider provideCellsForRowSearch
     * @covers ::getCellCoordinatesByRow
     */
    public function testGetCellCoordinatesByRow($cells, $targetRow, $expectedBoolean, $expectedArray)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }

        $this->assertEquals($expectedArray, $heading->getCellCoordinatesByRow($targetRow));
    }

    /**
     * @dataProvider provideCellsForColumnSearch
     * @covers ::getCellCoordinatesByColumn
     */
    public function testGetCellCoordinatesByColumn($cells, $targetColumn, $expectedBoolean, $expectedArray)
    {
        $heading = new XlsParserHeading('title');
        foreach ($cells as $cellItem) {
            $heading->addCellCoordinate($cellItem);
        }

        $this->assertEquals($expectedArray, $heading->getCellCoordinatesByColumn($targetColumn));
    }

    public function provideConstructorGoodArguments()
    {
        return [
            ['title', null, null],
            ['title', null, XlsParserHeading::TYPE_STRING],
            ['title', 'תאריך עדכון', null],
            ['title', 'תאריך עדכון', XlsParserHeading::TYPE_STRING],
            ['title', 'תאריך עדכון', XlsParserHeading::TYPE_DATE],
            ['title', 'תאריך עדכון', XlsParserHeading::TYPE_INTEGER],
        ];
    }

    public function provideConstructorBadArguments()
    {
        return [
            [null, null, null],
            ['title', 0, 0],
            ['title', null, []],
            ['title', null, new DateTime()],
            [0, 'updated_date', XlsParserHeading::TYPE_STRING],
        ];
    }

    public function provideHeadingNames()
    {
        return [
            ['title', 'title'],
            ['updated_date', 'updated_date'],
            ['תאריך עדכון', 'תאריך עדכון'],
        ];
    }

    public function provideAliases()
    {
        return [
            ['title', 'title'],
            ['updated_date', 'updated_date'],
            ['תאריך עדכון', 'תאריך עדכון'],
            ['', null],
            [null, null],
        ];
    }

    public function provideDataTypes()
    {
        return [
            [XlsParserHeading::TYPE_DATE, XlsParserHeading::TYPE_DATE],
            [XlsParserHeading::TYPE_INTEGER, XlsParserHeading::TYPE_INTEGER],
            [XlsParserHeading::TYPE_STRING, XlsParserHeading::TYPE_STRING],
            ['', XlsParserHeading::TYPE_STRING],
            [null, XlsParserHeading::TYPE_STRING],
        ];
    }

    public function provideGoodSpreadsheetCells()
    {
        return [
            [
                ['A1', 'F8'],
                2,
            ],
            [
                ['A1', 'F8', 'a1', 'f8'],
                2,
            ],
        ];
    }

    public function provideBadSpreadsheetCells()
    {
        return [
            ['1'],
            ['a'],
            ['abs-8'],
            [0],
            [null],
        ];
    }

    public function provideCellsForRowSearch()
    {
        return [
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                55,
                TRUE,
                ['C55'],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                6,
                FALSE,
                [],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                8,
                TRUE,
                ['F8', 'E8', 'H8'],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                '8',
                TRUE,
                ['F8', 'E8', 'H8'],
            ],
        ];
    }

    public function provideCellsForColumnSearch()
    {
        return [
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                'D',
                TRUE,
                ['D43'],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8'],
                'B',
                FALSE,
                [],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8', 'F16', 'F89'],
                'F',
                TRUE,
                ['F8', 'F16', 'F89'],
            ],
            [
                ['A1', 'F8', 'C55', 'D43', 'E8', 'H8', 'F16', 'F89'],
                6,
                TRUE,
                ['F8', 'F16', 'F89'],
            ],
        ];
    }
}