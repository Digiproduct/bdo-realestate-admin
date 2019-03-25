<?php

namespace Directus\Custom\Hooks\Imports;

use Directus\Application\Application;
use Directus\Services\FilesServices;
use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Exception\UnprocessableEntityException;
use Directus\Custom\Parsers\BalanceXlsParser;
use Directus\Custom\Parsers\ConstructionProgressXlsParser;
use Directus\Custom\Parsers\FundingReportsXlsParser;
use Directus\Custom\Parsers\ProfilesXlsParser;
use Directus\Custom\Parsers\ReceiptsXlsParser;
use Directus\Custom\Imports\BalanceDataImport;
use Directus\Custom\Imports\ConstructionProgressImport;
use Directus\Custom\Imports\FundingReportsImport;
use Directus\Custom\Imports\ProfilesImport;
use Directus\Custom\Imports\ReceiptsImport;

class BeforeCreateImport implements HookInterface
{
    /* @var string Balance data collection as import target */
    const TARGET_BALANCE_DATA = 'balance_data';

    /* @var string Construction Progress collection as import target */
    const TARGET_CONSTRUCTION_PROGRESS = 'construction_progress';

    /* @var string Funding Reports collections as import target */
    const TARGET_FUNDING_REPORTS = 'funding_reports';

    /* @var string Profiles collection as import target */
    const TARGET_PROFILES = 'profiles';

    /* @var string Receipts collection as import target */
    const TARGET_RECEIPTS = 'receipts';

    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        $app = Application::getInstance();
        $container = $app->getContainer();
        // Monolog\Logger instance
        $logger = $container->get('logger');
        $basePath = $container['path_base'];
        $importTarget = $payload->get('import_target');
        $parser;
        $import;
        switch (strtolower($importTarget)) {
            case self::TARGET_PROFILES:
                $parser = new ProfilesXlsParser();
                $import = new ProfilesImport($container);
                break;
            case self::TARGET_BALANCE_DATA:
                $parser = new BalanceXlsParser();
                $import = new BalanceDataImport($container);
                break;
            case self::TARGET_CONSTRUCTION_PROGRESS:
                $parser = new ConstructionProgressXlsParser();
                $import = new ConstructionProgressImport($container);
                break;
            case self::TARGET_FUNDING_REPORTS:
                $parser = new FundingReportsXlsParser();
                $import = new FundingReportsImport($container);
                break;
            case self::TARGET_RECEIPTS:
                $parser = new ReceiptsXlsParser();
                $import = new ReceiptsImport($container);
                break;
            default:
                throw new UnprocessableEntityException('Invalid import target');
        }

        $filesService = new FilesServices($container);
        $file = $filesService->findByIds($payload->get('excel_file'))['data'];
        $filePath = $basePath . '/public' . $file['data']['url'];
        $parsedData = $parser->parse($filePath);
        $import->execute($parsedData);
        $payload->set('items_created', $import->getCreatedCount());
        $payload->set('items_rejected', $import->getRejectedCount());
        if ($import->getRejectedCount() > 0) {
            $logger->warn('Rejected items', [
                'file_path' => $filePath,
                'import_type' => $importTarget,
                'items' => $import->getRejectedItems(),
            ]);
        }
        return $payload;
    }
}
