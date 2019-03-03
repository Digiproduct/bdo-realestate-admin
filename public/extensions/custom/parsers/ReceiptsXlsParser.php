<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\BaseXlsParser;
use Directus\Custom\Parsers\XlsParserHeading;

final class ReceiptsXlsParser extends BaseXlsParser
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct([
            new XlsParserHeading('contract_number', 'מספר חוזה'),
            new XlsParserHeading('request_amount', 'דרישה 1'),
            new XlsParserHeading('request_description', 'דרישה 1 מהות הדרישה'),
            new XlsParserHeading('request_date', 'תאריך אחרון', XlsParserHeading::TYPE_DATE),
            new XlsParserHeading('request_amount_2', 'דרישה 2'),
            new XlsParserHeading('request_description_2', 'דרישה 2 מהות הדירשה'),
            new XlsParserHeading('request_amount_3', 'דרישה 3'),
            new XlsParserHeading('request_description_3', 'דרישה 3 מהות הדרישה'),
            new XlsParserHeading('total_amount', 'סה"כ דרישות פתוחות'),
            new XlsParserHeading('updated_date', 'תאריך עדכון', XlsParserHeading::TYPE_DATE),
        ]);
    }

    protected function postProcessRecord($record, $sheet)
    {
        $record['request_date_2'] = ($record['request_amount_2']) ? $record['request_date'] : null;
        $record['request_date_3'] = ($record['request_amount_3']) ? $record['request_date'] : null;
        return $record;
    }
}
