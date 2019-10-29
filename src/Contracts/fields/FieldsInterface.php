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

    /**
     * @param $fieldId
     * @param $fields
     * @return mixed
     */
    public function updateField($fieldId, $fields);

    /**
     * @param $fieldId
     * @return mixed
     */
    public function deleteField($fieldId);
}