<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\BaseXlsParser;
use Directus\Custom\Parsers\XlsParserHeading;

final class ConstructionProgressXlsParser extends BaseXlsParser
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct([
            new XlsParserHeading('updated_date', 'תאריך עדכון', XlsParserHeading::TYPE_DATE),
            new XlsParserHeading('group_name', 'שם הקבוצה'),
            new XlsParserHeading('milestone_name', 'שלב'),
            new XlsParserHeading('is_complete', 'בוצע', XlsParserHeading::TYPE_BOOLEAN),
        ]);
    }
}
