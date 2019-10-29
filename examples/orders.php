<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/orders
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Order-operations
 *
 */

use Hellodialog\ApiWrapper\Contracts\orders\Order;
use Hellodialog\ApiWrapper\Contracts\orders\Product;
use Hellodialog\ApiWrapper\Handlers\OrdersHandler;
require_once('../vendor/autoload.php');
require_once('../src/config/Hellodialog.php');

$ordersHandler = new OrdersHandler();

// Get order
try {
    //$order = $ordersHandler->getOrder(1);
    //print_r($order);
} catch (Exception $e) {
    print_r($e);
}

// Get order data from order number or get orders count
try {
    $parameter = ['count' => true];
    $orders = $ordersHandler->getOrderWithParameters($parameter);
    print_r($orders);
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
    $order->order_number = '2';
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

    //$order = $ordersHandler->createOrder($order);
    //print_r($order);
} catch (Exception $e) {
    print_r($e);
}

// Update multiple orders status
try {
    $orders = [
        [ 'id' => 1, 'payment_status' => 'PAID'], // "PAID" "ERROR" "REFUND" "CANCELLED" "PENDING" "DENIED"
        [ 'id' => 2, 'payment_status' => 'ERROR'], // "PAID" "ERROR" "REFUND" "CANCELLED" "PENDING" "DENIED"
    ];

    //$ordersStatusUpdate = $ordersHandler->updateOrdersStatus($orders);
    //print_r($ordersStatusUpdate);
} catch (Exception $e) {
    print_r($e);
}


// Update single order status
try {
    //$orderStatusUpdate = $ordersHandler->updateOrderStatus(1, 'PAID');
    //print_r($orderStatusUpdate);
} catch (Exception $e) {
    print_r($e);
}

// Delete an order
try {
    //$orderDelete = $ordersHandler->deleteOrder(1);
    //print_r($orderDelete);
} catch (Exception $e) {
    print_r($e);
}