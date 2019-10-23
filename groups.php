<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/groups
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Groups-operations
 *
 */

use Czim\HelloDialog\Handlers\GroupsHandler;
require_once('vendor/autoload.php');
array_merge(require_once('src/config/app.php'), require_once('src/config/hellodialog.php'));

$groupsHandler = new GroupsHandler();

// Get account data
try {
    $groups = $groupsHandler->getGroups();
    print_r($groups);
} catch (Exception $e) {
    print_r($e);
}