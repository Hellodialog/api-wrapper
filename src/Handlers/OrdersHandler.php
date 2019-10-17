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

}