<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\orders\Order;
use Hellodialog\ApiWrapper\Contracts\orders\OrdersInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;

class OrdersHandler extends HelloDialogHandler implements OrdersInterface
{
    const API_ORDERS      = 'orders';

    /**
     * @return array
     * @throws Exception
     */
    public function getOrders()
    {
        // Does not exist
        $call = $this->getApiInstance(static::API_ORDERS);

        return $call->get() ?: [];
    }

    /**
     * @param $oderId
     * @return array
     * @throws Exception
     */
    public function getOrder($oderId)
    {
        $call = $this->getApiInstance(static::API_ORDERS);

        return $call->get($oderId) ?: [];
    }

    /**
     * @param Order $fields
     * @return array
     * @throws Exception
     */
    public function createOrder($fields)
    {
        $call = $this->getApiInstance(static::API_ORDERS)->data((array)$fields);

        return $call->post() ?: [];
    }

    /**
     * @param array $params
     * @return array|object    Order object
     * @throws Exception
     */
    public function getOrderWithParameters($params)
    {
        $call = $this->getApiInstance(static::API_ORDERS);
        foreach ($params as $param => $number){
            $call->parameter($param, $number);
        }

        return $call->get() ?: [];
    }

    /**
     * @param integer $orderId
     * @return array
     * @throws Exception
     */
    public function deleteOrder($orderId)
    {
        $call = $this->getApiInstance(static::API_ORDERS);

        return $call->delete($orderId) ?: [];
    }

    /**
     * @param integer $orderId
     * @param $paymentStatus
     * @return array
     * @throws Exception
     */
    public function updateOrderStatus($orderId, $paymentStatus)
    {
        $call = $this->getApiInstance(static::API_ORDERS)->data(['payment_status' => $paymentStatus]);

        return $call->put($orderId) ?: [];
    }

    /**
     * @param array $orders
     * @return array
     * @throws Exception
     */
    public function updateOrdersStatus($orders)
    {
        $call = $this->getApiInstance(static::API_ORDERS)->data($orders);

        return $call->put() ?: [];
    }
}