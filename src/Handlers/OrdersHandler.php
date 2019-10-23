<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\orders\OrdersInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

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

}