<?php

namespace Czim\HelloDialog\Contracts\orders;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
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
     * @param Order $fields
     * @return array
     */
    public function createOrder($fields);
}
