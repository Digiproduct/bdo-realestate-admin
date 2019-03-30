<?php

namespace Directus\Custom\Hooks\GroupMessages;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Application\Application;
use Directus\Services\ItemsService;
use Directus\Validator\Exception\InvalidRequestException;
use Directus\Database\Exception\DuplicateItemException;
use Directus\Database\Exception\ItemNotFoundException;
use Directus\Exception\UnprocessableEntityException;
use DateTime;

class BeforeCreateGroupMessage implements HookInterface
{
    /* @var string Contracts collection name */
    const COLLECTION_CONTRACTS = 'contracts';

    /* @var string Messages collection name */
    const COLLECTION_MESSAGES = 'messages';

    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        if ($payload->get('status', 'draft') !== 'published') {
            // not published, ignore
            return $payload;
        }

        if ($payload->get('recipients_count', 0) > 0) {
            // has been processed before, ignore
            return $payload;
        }

        // might take a lot of time
        set_time_limit(600);

        $app = Application::getInstance();
        $container = $app->getContainer();
        // Monolog\Logger instance
        $logger = $container->get('logger');
        $groupId = $payload->get('group', null);

        $itemsService = new ItemsService($container);
        $contractsSearchOptions = [
            'fields' => [
                'customer',
                'contract_number',
            ],
        ];
        if ($groupId) {
            // filter contracts by group
            $contractsSearchOptions['filter'] = [
                'group' => $groupId,
            ];
        }

        $contracts = [];
        $messages = [];
        try {
            $contracts = $itemsService->findAll(self::COLLECTION_CONTRACTS, $contractsSearchOptions)['data'];
        } catch (ItemNotFoundException $ex) {
            $log->error('Contracts not found', ['exception' => $ex]);
        }

        foreach ($contracts as $contractItem) {
            try {
                $container->get('acl')->setUserId($contractItem['customer']);
                $record = $itemsService->createItem(self::COLLECTION_MESSAGES, [
                    'contract_number' => $contractItem['contract_number'],
                    'subject' => $payload->get('subject'),
                    'message' => $payload->get('message'),
                    'attachment_1' => $payload->get('attachment_1', null),
                    'attachment_2' => $payload->get('attachment_2', null),
                    'attachment_3' => $payload->get('attachment_3', null),
                    'read_date' => null,
                    'status' => 'published',
                    'created_on' => $payload->get('created_on'),
                ]);
                $messages[] = $record;
            } catch (InvalidRequestException $ex) {
                $log->error('Invalid request', ['exception' => $ex]);
            } catch (DuplicateItemException $ex) {
                $log->error('Duplicate item', ['exception' => $ex]);
            } catch (UnprocessableEntityException $ex) {
                $log->error('Unprocessable entity', ['exception' => $ex]);
            }
        }

        $payload->set('recipients_count', count($messages));

        // make sure to return the payload
        return $payload;
    }
}
