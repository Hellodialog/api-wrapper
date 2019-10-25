<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\ping\PingInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class PingHandler extends HelloDialogHandler implements PingInterface
{
    const API_PING      = 'ping';

    /**
     * @return array
     * @throws Exception
     */
    public function getPing()
    {
        $call = $this->getApiInstance(static::API_PING);

        return $call->get() ?: [];
    }
}