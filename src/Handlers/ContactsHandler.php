<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\contacts\Contact;
use Czim\HelloDialog\Contracts\contacts\ContactsInterface;
use Czim\HelloDialog\Enums\ContactType;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;

class ContactsHandler extends HelloDialogHandler implements ContactsInterface {

    const API_CONTACTS      = 'contacts';
    const API_EXT_CONTACTS      = 'contacts/external_groups';

    /**
     * Creates or updates contact and returns contact ID if successful.
     *
     * @param array $fields
     * @param string $state
     * @return string|int|false    contact ID or false if failed
     * @throws Exception
     */
    public function saveContact(array $fields, $state = ContactType::OPT_IN)
    {
        // Update parameters to include state of contact
        try {
            $fields['_state'] = (string) new ContactType($state);

        } catch (Exception $e) {
            // Contact type was invalid, continue gracefully with optin state
            $fields['_state'] = ContactType::OPT_IN;
            $this->logException($e);
        }

        // Get contact if it exists
        $contact = $this->getContactByEmail($fields['email']);

        if ( ! $contact) {
            // E-mail does not yet exist in HelloDialog
            // Let's create the contact in HelloDialog
            try {
                $contactId = $this->createContact($fields);

            } catch (Exception $e) {
                $this->logException($e);
                return false;
            }

            return $contactId;
        }

        // Contact with that e-mail already exists, update in HelloDialog

        try {
            $fields['_state'] = (string) new ContactType($contact['_state']);

        } catch (Exception $e) {
            // Contact type was invalid, continue gracefully with contact state
            $fields['_state'] = ContactType::CONTACT;
        }

        // The API seems to be inconsistent and returns either a contact (object),
        // or an array of contacts.
        $contact = $this->normalizeToSingleContact($contact);

        $contactId = $contact['id'];

        try {
            $contact = $this->updateContact($contactId, $fields);

        } catch (Exception $e) {

            $this->logException($e);
            return false;
        }

        return $contactId;
    }

    /**
     * @param Contact $fields
     * @return array   array ID of generated contact
     * @throws Exception
     */
    public function createContact($fields)
    {
        $result = $this->getApiInstance(static::API_CONTACTS)
            ->data((array)$fields)
            ->post();

        $this->checkForHelloDialogError($result);

        return $result ?: [];
    }

    /**
     * @param string|int $contactId
     * @param array      $fields
     * @return string|int  ID of updated contact
     * @throws Exception
     */
    public function updateContact($contactId, array $fields)
    {
        $result = $this->getApiInstance(static::API_CONTACTS)
            ->data($fields)
            ->put($contactId);

        $this->checkForHelloDialogError($result);

        return array_get($result, 'result.data.id');
    }

    /**
     * @param string $email
     * @param string|string[]|null $type _state or list of states
     * @param bool $excludeType if true and type set, only matches where type does NOT match (any)
     * @return array|false
     * @throws Exception
     */
    public function getContactByEmail($email, $type = null, $excludeType = false)
    {
        $contacts = $this->getContactsByEmail($email, $type, $excludeType);

        if ( ! count($contacts)) {
            return false;
        }

        return head($contacts);
    }

    /**
     * @param string $email
     * @param string|string[]|null $type _state or list of states
     * @param bool $excludeType if true and type set, only matches where type does NOT match (any)
     * @return array
     * @throws Exception
     */
    public function getContactsByEmail($email, $type = null, $excludeType = false)
    {
        // Check if the enum value is correct
        if (is_string($type)) {
            new ContactType($type);
        } elseif (is_array($type)) {
            array_map(function ($type) { new ContactType($type); }, $type);
        }

        $call = $this->getApiInstance(static::API_CONTACTS)
            ->condition('email', $email, 'equals');

        if (null !== $type) {

            if (is_array($type)) {
                if ($excludeType) {
                    $call->condition('_state', implode(',', $type), 'not-equals-any');
                } else {
                    $call->condition('_state', implode(',', $type), 'equals-any');
                }
            } else {
                if ($excludeType) {
                    $call->condition('_state', $type, 'not-equals');
                } else {
                    $call->condition('_state', $type, 'equals');
                }
            }
        }

        $contacts = $call->get();

        return $contacts ?: [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getContacts()
    {
        $call = $this->getApiInstance(static::API_CONTACTS)
            ->condition('voornaam', 'not-existing', 'not-equals');
        $contacts = $call->get();

        return $contacts ?: [];
    }

    /**
     * @param string $email
     * @param string|string[] $type _state or list of states
     * @param bool $excludeType if true and type set, only matches where type does NOT match (any)
     * @return bool
     * @throws Exception
     */
    public function checkIfEmailExists($email, $type = null, $excludeType = false)
    {
        return (bool) $this->getContactByEmail($email, $type, $excludeType);
    }

    /**
     * @param Contact $fields
     * @return array   array with ID of generated contact
     * @throws Exception
     */
    public function createExternalContact($fields)
    {
        $result = $this->getApiInstance(static::API_EXT_CONTACTS)
            ->data((array)$fields)
            ->post();

        $this->checkForHelloDialogError($result);

        return $result ?: [];
    }
}