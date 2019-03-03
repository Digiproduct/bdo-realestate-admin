<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\BaseXlsParser;
use Directus\Custom\Parsers\XlsParserHeading;
use PhpOffice\PhpSpreadsheet\IOFactory;

final class BalanceXlsParser extends BaseXlsParser
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct([
            new XlsParserHeading('contract_number', 'מספר חוזה'),
            new XlsParserHeading('unit_cost', 'עלות יחידה משוער (אומדן)',XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('funds', 'הון עצמי', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('land_amount', 'קרקע', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('land_completeness', 'שיעור השלמה קרקע', XlsParserHeading::TYPE_PERCENT),
            new XlsParserHeading('construction_amount', 'בניה כולל מעמ', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('construction_completeness', 'שיעור השלמה בניה', XlsParserHeading::TYPE_PERCENT),
            new XlsParserHeading('management_amount', 'ניהול וכלליות', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('management_completeness', 'שיעור השלמה ניהול', XlsParserHeading::TYPE_PERCENT),
            new XlsParserHeading('balance', 'יתרת רוכש 15/12/18', XlsParserHeading::TYPE_INTEGER),
            new XlsParserHeading('updated_date', 'תאריך עדכון', XlsParserHeading::TYPE_DATE),
        ]);
    }

    public function parse($filePath, $options = null)
    {
        $options = [
            'spreadsheetIndex' => 0,
            'parseHiddenCells' => true,
            'parseCollapsedCells' => true,
        ];
        return parent::parse($filePath, $options);
    }
}
