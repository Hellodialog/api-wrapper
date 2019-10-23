<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/lists
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Lists-operations
 *
 */

use Czim\HelloDialog\Handlers\ListsHandler;
require_once('vendor/autoload.php');
array_merge(require_once('src/config/app.php'), require_once('src/config/hellodialog.php'));

$listsHandler = new ListsHandler();

// Get all lists
try {
    $lists = $listsHandler->getLists();
    print_r($lists);
} catch (Exception $e) {
    print_r($e);
}