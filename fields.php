<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/fields
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Field-operations
 *
 */

use Czim\HelloDialog\Handlers\FieldsHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$fieldsHandler = new FieldsHandler();

// Get all fields
try {
    $fields = $fieldsHandler->getFields();
    print_r($fields);
} catch (Exception $e) {
    print_r($e);
}