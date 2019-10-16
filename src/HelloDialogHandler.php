<?php
namespace Czim\HelloDialog;

use Czim\HelloDialog\Contracts\HelloDialogApiFactoryInterface;
use Czim\HelloDialog\Contracts\HelloDialogApiInterface;
use Czim\HelloDialog\Contracts\HelloDialogHandlerInterface;
use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Czim\HelloDialog\Enums\ContactType;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class HelloDialogHandler implements HelloDialogHandlerInterface
{
    const API_CONTACTS      = 'contacts';
    const API_NEWSLETTERS   = 'newsletter';
    const API_TRANSACTIONAL = 'transactional';

    /**
     * Logger. If not set, logs using the Log facade.
     *
     * @var null|LoggerInterface
     */
    protected $logger;

    /**
     * @var HelloDialogApiInterface[]
     */
    protected $apiInstances = [];


    /**
     * @param LoggerInterface|null $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }


    /**
     * @param string      $to
     * @param string      $subject
     * @param int         $template
     * @param null|array  $from associative, 'email', 'name' keys
     * @param array       $replaces
     * @param null|string $replyToMail
     * @return bool
     * @throws HelloDialogErrorException
     * @throws HelloDialogGeneralException
     */
    public function transactional($to, $subject, $template = null, array $from = null, array $replaces = [], $replyToMail = null)
    {
        $from = $from ?: config('hellodialog.sender');

        $template = $template ?: config('hellodialog.default_template');
        $template = $this->normalizeTemplate($template);

        // Build normalized replaces array
        $normalizedReplaces = [];

        if ($replaces) {

            foreach ($replaces as $search => $replace) {
                $normalizedReplaces[] = [
                    'find'    => $search,
                    'replace' => $replace,
                ];
            }
        }

        $data = [
            'to'            => $to,
            'from'          => $from,
            'subject'       => $subject,
            'template'      => [
                'id'       => $template,
                'replaces' => $normalizedReplaces,
            ],
            'tag'           => $subject,
            'force_sending' => true,
        ];

        // Reply to email may differ
        if (null !== $replyToMail) {
            array_set($data, 'reply_to.email', $replyToMail);
        }

        try {
            $result = $this->getApiInstance(static::API_TRANSACTIONAL)
                ->data($data)
                ->post();
            
            if ( ! $result) {
                throw new HelloDialogGeneralException('No result given, configuration error?');
            }

            if (config('hellodialog.debug')) {
                $this->log(static::API_TRANSACTIONAL, 'debug', [
                    'data'   => $data,
                    'result' => $result,
                ]);
            }

            $this->checkForHelloDialogError($result);

        } catch (Exception $e) {

            $this->logException($e);
            return false;
        }

        return array_get($result, 'result.data', []);
    }

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
     * @param string          $email
     * @param string|string[] $type         _state or list of states
     * @param bool            $excludeType  if true and type set, only matches where type does NOT match (any)
     * @return bool
     */
    public function checkIfEmailExists($email, $type = null, $excludeType = false)
    {
        return (bool) $this->getContactByEmail($email, $type, $excludeType);
    }

    /**
     * Fetches the contents of a template, optionally performing placeholder replaces.
     *
     * @param int   $templateId
     * @param array $replaces
     * @return string
     */
    public function getTemplateContents($templateId, array $replaces = [])
    {
        $result = $this->getApiInstance(static::API_NEWSLETTERS)->get($templateId);

        $this->checkForHelloDialogError($result);

        $result = $result['html'];

        if (count($replaces)) {
            $result = str_replace(array_keys($replaces), array_values($replaces), $result);
        }

        return $result;
    }


    /**
     * Normalizes expected contact data to a single associative array, if possible.
     *
     * @param mixed $contacts
     * @return false|array
     */
    protected function normalizeToSingleContact($contacts)
    {
        if (  ! is_array($contacts)) {
            return $contacts;
        }

        if (array_key_exists('id', $contacts)) {
            return $contacts;
        }

        return head($contacts);
    }

    /**
     * @param string $type
     * @return HelloDialogApiInterface
     */
    protected function getApiInstance($type = self::API_TRANSACTIONAL)
    {
        if ( ! isset($this->apiInstances[ $type ])) {
            $this->apiInstances[ $type ] = $this->buildApiInstance($type);
        }
        
        return $this->apiInstances[ $type ];
    }

    /**
     * @param string $type
     * @return HelloDialogApiInterface
     */
    protected function buildApiInstance($type)
    {
        return app(HelloDialogApiFactoryInterface::class)->make($type);
    }

    /**
     * Normalizes template to template ID
     *
     * @param mixed $template
     * @return int
     */
    protected function normalizeTemplate($template)
    {
        if (is_string($template)) {
            $template = config('hellodialog.templates.' . $template .'.id');

            if ( ! $template) {
                throw new UnexpectedValueException("Could not find template ID by name '{$template}'.");
            }
        }

        return (int) $template;
    }

    /**
     * Checks a result array returned from HelloDialog for an error.
     * Throws exception if found.
     *
     * @param array|mixed $result
     * @throws HelloDialogErrorException
     * @throws HelloDialogGeneralException
     */
    protected function checkForHelloDialogError($result)
    {
        if ( ! is_array($result)) {
            throw new HelloDialogGeneralException('Expected array result from HelloDialog');
        }

        $resultCode = (int) array_get($result, 'result.code', 0);

        if ($resultCode < 200 || $resultCode > 299) {
            throw new HelloDialogErrorException(array_get($result, 'result.message'), $resultCode);
        }
    }

    /**
     * Writes exception information to the log
     *
     * @param Exception $e
     */
    protected function logException(Exception $e)
    {
        $this->log($e->getMessage(), 'error', [ 'exception' => $e ]);
    }

    /**
     * @param       $type
     * @param array $extra
     */
    protected function logActivity($type, array $extra = [])
    {
        $this->log($type, 'debug', $extra);
    }

    /**
     * @param string $message
     * @param string $level
     * @param array  $extra
     */
    protected function log($message, $level = 'debug', array $extra = [])
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $extra);
            return;
        }

        Log::log($level, $message, $extra);
    }

}
