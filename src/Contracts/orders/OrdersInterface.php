<?php

namespace Hellodialog\ApiWrapper\Contracts\orders;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
use Exception;

interface OrdersInterface
{
    /**
     * @return array
     */
    public function getOrders();

    /**
     * @param string|int    $orderId
     * @return array|object    Order object
     * @throws Exception
     */
    public function getOrder($orderId);

    /**
     * @param array    $params
     * @return array|object    Order object
     * @throws Exception
     */
    public function getOrderWithParameters($params);

    /**
     * @param Order $fields
     * @return array
     */
    public function createOrder($fields);

    /**
     * @param integer $orderId
     * @return array
     */
    public function deleteOrder($orderId);

    /**
     * @param integer $orderId
     * @param $paymentStatus
     * @return array
     */
    public function updateOrderStatus($orderId, $paymentStatus);

    /**
     * @param array $orders
     * @return array
     */
    public function updateOrdersStatus($orders);
}
