<?php

namespace Czim\HelloDialog\Contracts\contacts;

use Czim\HelloDialog\Enums\ContactType;
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
     * @param array $fields
     * @return string|int   ID of generated contact
     * @throws Exception
     */
    public function createContact(array $fields);

    /**
     * @param string|int $contactId
     * @param array      $fields
     * @return string|int  ID of updated contact
     * @throws Exception
     */
    public function updateContact($contactId, array $fields);

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
}