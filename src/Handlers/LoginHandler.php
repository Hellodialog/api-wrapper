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

}