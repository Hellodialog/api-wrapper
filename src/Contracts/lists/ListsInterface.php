<?php

namespace Czim\HelloDialog\Contracts\lists;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
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
}
