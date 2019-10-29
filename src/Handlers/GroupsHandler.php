<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\groups\Group;
use Hellodialog\ApiWrapper\Contracts\groups\GroupsInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;

class GroupsHandler extends HelloDialogHandler implements GroupsInterface
{
    const API_GROUPS    = 'groups';
    const API_EXT_GROUPS= 'groups/external';

    /**
     * @param array $fields
     * @return string|int|false    group ID or false if failed
     */
    public function saveGroup(array $fields)
    {
        // TODO: Implement saveGroup() method.
    }

    /**
     * @param Group $fields
     * @return array   array with ID of generated group
     * @throws Exception
     */
    public function createGroup($fields)
    {
        $call = $this->getApiInstance(static::API_GROUPS)->data((array)$fields);

        return $call->post() ?: [];
    }

    /**
     * @param string|int $groupId
     * @param array $fields
     * @return array   array with ID of generated group
     * @throws Exception
     */
    public function updateGroup($groupId, array $fields)
    {
        $call = $this->getApiInstance(static::API_GROUPS)->data((array)$fields);

        return $call->put($groupId) ?: [];
    }

    /**
     * @param string|int $groupId
     * @return array|object    Group object
     * @throws Exception
     */
    public function getGroup($groupId)
    {
        $call = $this->getApiInstance(static::API_GROUPS.'/'.$groupId);

        return $call->get() ?: [];
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

    /**
     * @param string|int $extGroupId
     * @return array|object    Group object
     * @throws Exception
     */
    public function getExternalGroup($extGroupId)
    {
        $call = $this->getApiInstance(static::API_EXT_GROUPS.'/'.$extGroupId);

        return $call->get() ?: [];
    }

    /**
     * @return array|object    Groups array
     * @throws Exception
     */
    public function getExternalGroups()
    {
        $call = $this->getApiInstance(static::API_EXT_GROUPS);

        return $call->get() ?: [];
    }

    /**
     * @param $groupId
     * @return mixed
     * @throws Exception
     */
    public function deleteGroup($groupId)
    {
        $call = $this->getApiInstance(static::API_GROUPS);

        return $call->delete($groupId) ?: [];
    }
}