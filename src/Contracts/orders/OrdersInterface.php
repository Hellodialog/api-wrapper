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
     * @param Order $fields
     * @return array
     */
    public function createOrder($fields);
}
