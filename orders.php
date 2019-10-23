<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/orders
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Order-operations
 *
 */

use Czim\HelloDialog\Handlers\OrdersHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$ordersHandler = new OrdersHandler();

// Get order
try {
    $order = $ordersHandler->getOrder(0);
    print_r($order);
} catch (Exception $e) {
    print_r($e);
}