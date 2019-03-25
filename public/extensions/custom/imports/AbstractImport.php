<?php

namespace Directus\Custom\Imports;

use Directus\Services\ItemsService;
use Directus\Application\Container;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;

/**
 * Abstract import class.
 *
 * @codeCoverageIgnore
 */
abstract class AbstractImport
{
    /* @var Container App container */
    protected $container;

    /* @var array List of created items */
    protected $createdItems = [];

    /* @var array List of rejected items */
    protected $rejectedItems = [];

    /**
     * Class constructor.
     *
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Executes the import process.
     *
     * @param array $data Import data
     */
    abstract public function execute(array $data);

    /**
     * Removes invisible characters from all payload properties.
     *
     * @param array $payload Payload
     *
     * @return array
     */
    final protected function stripPayloadStrings(array $payload)
    {
        if (!is_array($payload)) return $payload;

        foreach ($payload as $key => $value) {
            $payload[$key] = $this->stripString($value);
        }
        return $payload;
    }

    /**
     * Removes invisible charachters and white spaces from string.
     *
     * @param string $value String
     *
     * @return string
     */
    final protected function stripString($value)
    {
        if(!is_string($value)) return $value;

        // remove invisible chars
        $value = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $value);

        // remove rtl and other special chars
        $value = preg_replace('/(\x{200e}|\x{200f})/u', '', $value);

        return trim($value);
    }

    /**
     * Extracts phone from provided string.
     *
     * @param string $phoneStr      Text with formatted phone
     * @param string $defaultLocale Default phone country (optional)
     *
     * @return null|string Phone in E164 format or null when phone string is invalid
     */
    final protected function parsePhone($phoneStr, $defaultLocale = 'IL')
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($phoneStr, $defaultLocale);
            if ($phoneUtil->isValidNumber($numberProto)) {
                return $phoneUtil->format($numberProto, PhoneNumberFormat::E164);
            }
        } catch (NumberParseException $e) {
            return null;
        }

        return null;
    }

    /**
     * Get created entities.
     *
     * @return array
     */
    final public function getCreatedItems()
    {
        return $this->createdItems;
    }

    /**
     * Get rejected entities.
     *
     * @return array
     */
    final public function getRejectedItems()
    {
        return $this->rejectedItems;
    }

    /**
     * Counts created items.
     *
     * @return int
     */
    final public function getCreatedCount()
    {
        return count($this->createdItems);
    }

    /**
     * Counts rejected items.
     *
     * @return int
     */
    final public function getRejectedCount()
    {
        return count($this->rejectedItems);
    }

    /**
     * Adds rejected item.
     *
     * @param array       $payload Rejected item payload
     * @param string|null $reason  Rejected reason
     */
    final public function addRejectedItem(array $payload, $reason = null)
    {
        $this->rejectedItems[] = [
            'reason' => $reason,
            'payload' => $payload,
        ];
    }
}
