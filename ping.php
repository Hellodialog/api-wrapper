<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/ping
 * Documentation url: https://docs.hellodialog.dev/v1/#operation/getPing
 *
 */

use Czim\HelloDialog\Handlers\PingHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$pingHandler = new PingHandler();

// Get account data
try {
    $ping = $pingHandler->getPing();
    print_r($ping);
} catch (Exception $e) {
    print_r($e);
}