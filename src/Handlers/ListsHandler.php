<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\lists\ListsInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class ListsHandler extends HelloDialogHandler implements ListsInterface
{
    const API_LISTS      = 'lists';

    /**
     * @param string|int $listId
     * @return array|object    List object
     * @throws Exception
     */
    public function getList($listId)
    {
        // TODO: Implement getList() method.
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
}