<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\fields\FieldsInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class FieldsHandler extends HelloDialogHandler implements FieldsInterface
{
    const API_FIELDS      = 'fields';

    /**
     * @return array
     * @throws Exception
     */
    public function getFields()
    {
        $call = $this->getApiInstance(static::API_FIELDS);

        return $call->get() ?: [];
    }
}