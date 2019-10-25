<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\lists\ListsInterface;
use Hellodialog\ApiWrapper\Contracts\lists\Segment;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class ListsHandler extends HelloDialogHandler implements ListsInterface
{
    const API_LISTS      = 'lists';

    /**
     * @return array|object    List object
     * @param string|int $listId
     * @throws Exception
     */
    public function getList($listId)
    {
        $call = $this->getApiInstance(static::API_LISTS.'/'.$listId);

        return $call->get() ?: [];
    }

    /**
     * @return array|object    Lists array
     * @throws Exception
     */
    public function getLists()
    {
        $call = $this->getApiInstance(static::API_LISTS);

        return $call->get() ?: [];
    }

    /**
     * @param Segment $fields
     * @return array
     * @throws Exception
     */
    public function createList($fields)
    {
        $call = $this->getApiInstance(static::API_LISTS)->data((array)$fields);

        return $call->post() ?: [];
    }
}