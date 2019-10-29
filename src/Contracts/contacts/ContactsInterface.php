<?php

namespace Hellodialog\ApiWrapper\Contracts\contacts;

use Hellodialog\ApiWrapper\Enums\ContactType;
use Exception;

interface ContactsInterface
{
    /**
     * @param array  $fields
     * @param string $state
     * @return string|int|false    contact ID or false if failed
     */
    public function saveContact(array $fields, $state = ContactType::OPT_IN);

    /**
     * @param Contact $fields
     * @return array   array with ID of generated contact
     * @throws Exception
     */
    public function createContact($fields);

    /**
     * @param Contact $fields
     * @return array   array with ID of generated contact
     * @throws Exception
     */
    public function createExternalContact($fields);

    /**
     * @param string|int $contactId
     * @param array      $fields
     * @return string|int  ID of updated contact
     * @throws Exception
     */
    public function updateContact($contactId, array $fields);

    /**
     * @param array      $contacts
     * @return string|int  ID of updated contact
     * @throws Exception
     */
    public function updateContacts(array $contacts);

    /**
     * @param $contactId
     * @return mixed
     * @throws Exception
     */
    public function deleteContact($contactId);

    /**
     * @param string               $email
     * @param string|string[]|null $type            _state value, ContactType enum or list of
     * @param bool                 $excludeType     if true and type set, only matches where type does NOT match (any)
     * @return bool
     */
    public function checkIfEmailExists($email, $type = null, $excludeType = false);

    /**
     * @param string               $email
     * @param string|string[]|null $type            _state, ContactType enum, or list of
     * @param bool                 $excludeType     if true and type set, only matches where type does NOT match (any)
     * @return array|false
     */
    public function getContactByEmail($email, $type = null, $excludeType = false);

    /**
     * @param string               $email
     * @param string|string[]|null $type            _state, ContactType enum
     * @param bool                 $excludeType     if true and type set, only matches where type does NOT match (any)
     * @return array
     */
    public function getContactsByEmail($email, $type = null, $excludeType = false);

    /**
     * @param $parameters
     * @param int $page
     * @return array
     */
    public function getContactsByParameters($parameters, $page = 0);

    /**
     * @return array
     */
    public function getContacts();
}
