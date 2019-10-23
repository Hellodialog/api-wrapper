<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\login\LoginInterface;
use Czim\HelloDialog\HelloDialogHandler;
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