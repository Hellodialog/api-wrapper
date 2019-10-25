<?php
/**
 * Class Order
 * @package Czim\HelloDialog\Contracts\orders
 */
namespace Czim\HelloDialog\Contracts\orders;

class Order {

    public $contact;
    public $order_number;
    public $created_on;
    public $price;
    public $payment_method;
    public $payment_status;
    public $discount;
    public $zip_code;
    public $lat;
    public $lng;
    public $country;
    public $coupon;
    public $products;

}