<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\contacts\ContactsInterface;
use Czim\HelloDialog\Enums\ContactType;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class ContactsHandler extends HelloDialogHandler implements ContactsInterface {

    const API_CONTACTS      = 'contacts';

    /**
     * Creates or updates contact and returns contact ID if successful.
     *
     * @param array  $fields
     * @param string $state
     * @return string|int|false    contact ID or false if failed
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

                if (config('hellodialog.debug')) {
                    $this->log('createContact', 'debug', [
                        'contactId' => $contactId,
                        'state'     => $state,
                        'data'      => $fields,
                        'new'       => true,
                    ]);
                }

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

            if (config('hellodialog.debug')) {
                $this->log('createContact', 'debug', [
                    'state'   => $state,
                    'data'    => $fields,
                    'contact' => $contact,
                ]);
            }

        } catch (Exception $e) {

            $this->logException($e);
            return false;
        }

        return $contactId;
    }

    /**
     * @param array $fields
     * @return string|int   ID of generated contact
     * @throws Exception
     */
    public function createContact(array $fields)
    {
        $result = $this->getApiInstance(static::API_CONTACTS)
            ->data($fields)
            ->post();

        $this->checkForHelloDialogError($result);

        if (config('hellodialog.debug')) {
            $this->log('createContact', 'debug', [
                'data'   => $fields,
                'result' => $result,
            ]);
        }

        return array_get($result, 'result.data.id');
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

        if (config('hellodialog.debug')) {
            $this->log('updateContact', 'debug', [
                'contactId' => $contactId,
                'data'      => $fields,
                'result'    => $result,
            ]);
        }

        return array_get($result, 'result.data.id');
    }

    /**
     * @param string               $email
     * @param string|string[]|null $type            _state or list of states
     * @param bool                 $excludeType     if true and type set, only matches where type does NOT match (any)
     * @return array|false
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
     * @param string               $email
     * @param string|string[]|null $type            _state or list of states
     * @param bool                 $excludeType     if true and type set, only matches where type does NOT match (any)
     * @return array
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
     */
    public function getContacts()
    {
        $call = $this->getApiInstance(static::API_CONTACTS)
            ->condition('voornaam', 'not-existing', 'not-equals');
        $contacts = $call->get();

        return $contacts ?: [];
    }

    /**
     * @param string          $email
     * @param string|string[] $type         _state or list of states
     * @param bool            $excludeType  if true and type set, only matches where type does NOT match (any)
     * @return bool
     */
    public function checkIfEmailExists($email, $type = null, $excludeType = false)
    {
        return (bool) $this->getContactByEmail($email, $type, $excludeType);
    }
}