<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/fields
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Field-operations
 *
 */

use Czim\HelloDialog\Contracts\fields\Field;
use Czim\HelloDialog\Handlers\FieldsHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$fieldsHandler = new FieldsHandler();

// Get all fields
try {
    $fields = $fieldsHandler->getFields();
    //print_r($fields);
} catch (Exception $e) {
    print_r($e);
}

// Get a single field
try {
    $field = $fieldsHandler->getField(1);
    //print_r($field);
} catch (Exception $e) {
    print_r($e);
}

// Post a field
try {
    $field = new Field();
    $field->name = 'Test field 12';
    $field->type = 'Dropdown';
    $field->options = ['values' => ['test 1', 'test 2']];

    // $field->removable is always true
    $field->removable = true;

    // accepted: true, false, 0, 1, "0", "1"
    $field->user_viewable = false;

    // accepted: true, false, 0, 1, "0", "1"
    $field->user_editable = 0;

    //$fields = $fieldsHandler->createField($field);
    //print_r($fields);
} catch (Exception $e) {
    print_r($e);
}