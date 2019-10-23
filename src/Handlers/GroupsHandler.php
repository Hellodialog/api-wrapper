<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\groups\GroupsInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class GroupsHandler extends HelloDialogHandler implements GroupsInterface
{
    const API_GROUPS    = 'groups';

    /**
     * @param array $fields
     * @return string|int|false    group ID or false if failed
     */
    public function saveGroup(array $fields)
    {
        // TODO: Implement saveGroup() method.
    }

    /**
     * @param array $fields
     * @return string|int   ID of generated group
     * @throws Exception
     */
    public function createGroup(array $fields)
    {
        // TODO: Implement createGroup() method.
    }

    /**
     * @param string|int $groupId
     * @param array $fields
     * @return string|int  ID of updated group
     * @throws Exception
     */
    public function updateGroup($groupId, array $fields)
    {
        // TODO: Implement updateGroup() method.
    }

    /**
     * @param string|int $groupId
     * @return array|object    Group object
     * @throws Exception
     */
    public function getGroup($groupId)
    {
        // TODO: Implement getGroup() method.
    }

    /**
     * @return array|object    Groups array
     * @throws Exception
     */
    public function getGroups()
    {
        $call = $this->getApiInstance(static::API_GROUPS);

        return $call->get() ?: [];
    }
}