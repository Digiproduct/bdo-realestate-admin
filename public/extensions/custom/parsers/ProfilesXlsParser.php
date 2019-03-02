<?php

namespace Directus\Custom\Parsers;

use Directus\Custom\Parsers\BaseXlsParser;
use Directus\Custom\Parsers\XlsParserHeading;

final class ProfilesXlsParser extends BaseXlsParser
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct([
            new XlsParserHeading('updated_date', 'תאריך עדכון', XlsParserHeading::TYPE_DATE),
            new XlsParserHeading('contract_number', 'מספר חוזה'),
            new XlsParserHeading('group_name', 'קבוצה'),
            new XlsParserHeading('fullname', 'שם רוכש'),
            new XlsParserHeading('passport', 'מ.ז.'),
            new XlsParserHeading('phone_1', 'טלפון 1'),
            new XlsParserHeading('phone_2', 'טלפון 2'),
            new XlsParserHeading('email', 'כתובת מייל'),
            new XlsParserHeading('home_address', 'כתובת'),
            new XlsParserHeading('building_plot', 'מגרש'),
            new XlsParserHeading('building_number', 'מספר בנין'),
            new XlsParserHeading('apartment', 'מספר דירה'),
            new XlsParserHeading('floor', 'קומה'),
            new XlsParserHeading('rooms', 'מספר חדרים'),
        ]);
    }
}
