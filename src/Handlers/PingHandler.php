<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\ping\PingInterface;
use Czim\HelloDialog\HelloDialogHandler;
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