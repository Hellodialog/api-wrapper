<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/orders
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Order-operations
 *
 */

use Czim\HelloDialog\Contracts\orders\Order;
use Czim\HelloDialog\Contracts\orders\Product;
use Czim\HelloDialog\Handlers\OrdersHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$ordersHandler = new OrdersHandler();

// Get order
try {
    //$order = $ordersHandler->getOrder(1);
    //print_r($order);
} catch (Exception $e) {
    print_r($e);
}

// Post an order
try {
    $product = new Product();
    $product->product_code = 'AKCU-29182';
    $product->name = 'Razer Keyboard';
    $product->quantity = 1;
    $product->price = 15.5;
    $product->brand = 'Razer';
    $product->discount = 2.12;
    $product->category = 'Peripherals';
    $product->subcategory = 'Keyboards';

    $order = new Order();
    $order->contact = 3;
    $order->order_number = '1';
    $order->created_on = 1571992388;
    $order->price = 49.99;
    $order->payment_method = 'PAYPAL';
    $order->payment_status = 'PAID';
    $order->discount = 10.49;
    $order->zip_code = '2011KC';
    $order->lat = 52.386639;
    $order->lng = 4.64302;
    $order->country = 'NL';
    $order->coupon = 'SALE90';
    $order->products = [
        $product
    ];

    $order = $ordersHandler->createOrder($order);
    print_r($order);
} catch (Exception $e) {
    print_r($e);
}