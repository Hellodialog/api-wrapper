<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/lists
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Lists-operations
 *
 */

use Czim\HelloDialog\Contracts\lists\Segment;
use Czim\HelloDialog\Handlers\ListsHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$listsHandler = new ListsHandler();

// Get all lists
try {
    $lists = $listsHandler->getLists();
    //print_r($lists);
} catch (Exception $e) {
    print_r($e);
}

// Get a single list
try {
    $list = $listsHandler->getList(1);
    //print_r($list);
} catch (Exception $e) {
    print_r($e);
}

// Post a list
try {
    $list = new Segment();
    $list->name = 'Test Segment';
    $list->description = 'A short description';
    $list->contacts = [1];
    //$result = $listsHandler->createList($list);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}