<?php

namespace Hellodialog\ApiWrapper\Contracts\lists;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
use Exception;

interface ListsInterface
{

    /**
     * @param string|int    $listId
     * @return array|object    List object
     * @throws Exception
     */
    public function getList($listId);

    /**
     * @return array|object    Lists array
     * @throws Exception
     */
    public function getLists();

    /**
     * @param Segment $fields
     * @throws Exception
     */
    public function createList($fields);

    /**
     * @param $listId
     * @param Segment $fields
     * @throws Exception
     */
    public function updateList($listId, $fields);

    /**
     * @param $listId
     * @return mixed
     */
    public function deleteList($listId);

    /**
     * @param $listId
     * @return mixed
     */
    public function listCampaigns($listId);
}
