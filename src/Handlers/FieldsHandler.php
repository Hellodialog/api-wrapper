<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\fields\Field;
use Hellodialog\ApiWrapper\Contracts\fields\FieldsInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
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

    /**
     * @param $fieldId
     * @param $fields
     * @return mixed
     * @throws Exception
     */
    public function updateField($fieldId, $fields)
    {
        $call = $this->getApiInstance(static::API_FIELDS)->data((array)$fields);
        return $call->put($fieldId);
    }

    public function deleteField($fieldId)
    {
        $call = $this->getApiInstance(static::API_FIELDS);
        return $call->delete($fieldId);
    }
}