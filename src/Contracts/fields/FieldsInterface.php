<?php

namespace Hellodialog\ApiWrapper\Contracts\fields;

use Exception;

interface FieldsInterface
{
    /**
     * @return array
     */
    public function getFields();

    /**
     * @param $fieldId
     * @return array|object
     */
    public function getField($fieldId);

    /**
     * @param Field $fields
     * @return mixed
     */
    public function createField($fields);
}