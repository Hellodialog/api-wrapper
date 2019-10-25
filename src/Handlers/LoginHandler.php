<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\login\LoginInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class LoginHandler extends HelloDialogHandler implements LoginInterface
{
    const API_LOGIN      = 'login';

    /**
     * @return array
     */
    public function getLogin()
    {
        $call = $this->getApiInstance(static::API_LOGIN);

        return $call->get() ?: [];
    }
}