<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\fields\Field;
use Czim\HelloDialog\Contracts\fields\FieldsInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;

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

    /**
     * @param $fieldId
     * @return array|object
     * @throws Exception
     */
    public function getField($fieldId)
    {
        $call = $this->getApiInstance(static::API_FIELDS.'/'.$fieldId);

        return $call->get() ?: [];
    }

    /**
     * @param Field $fields
     * @return array|object
     * @throws Exception
     */
    public function createField($fields)
    {
        $call = $this->getApiInstance(static::API_FIELDS)->data((array)$fields);

        return $call->post() ?: [];
    }
}