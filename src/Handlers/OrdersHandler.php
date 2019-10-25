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
        $call = $this->getApiInstance(static::API_ORDERS.'/'.$oderId);

        return $call->get() ?: [];
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
}