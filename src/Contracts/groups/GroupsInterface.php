<?php

namespace Czim\HelloDialog\Contracts\groups;

use Exception;

interface GroupsInterface
{
    /**
     * @param array  $fields
     * @return string|int|false    group ID or false if failed
     */
    public function saveGroup(array $fields);

    /**
     * @param Group $fields
     * @return array   array with ID of generated group
     * @throws Exception
     */
    public function createGroup($fields);

    /**
     * @param string|int $groupId
     * @param array      $fields
     * @return string|int  ID of updated group
     * @throws Exception
     */
    public function updateGroup($groupId, array $fields);

    /**
     * @param string|int    $groupId
     * @return array|object    Group object
     * @throws Exception
     */
    public function getGroup($groupId);

    /**
     * @return array|object    Groups array
     * @throws Exception
     */
    public function getGroups();

}