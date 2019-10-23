<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/transactional
 * Documentation url: https://docs.hellodialog.dev/v1/#operation/postTransactional
 *
 */

use Czim\HelloDialog\Handlers\TransactionalHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$transactionalHandler = new TransactionalHandler();

// Send transactional mail
try {
    $transactional = $transactionalHandler->transactional("bart@hellodialog.com", "Test");
    print_r($transactional);
} catch (Exception $e) {
    print_r($e);
}