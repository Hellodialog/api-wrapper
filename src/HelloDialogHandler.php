<?php
namespace Czim\HelloDialog;

use Czim\HelloDialog\Contracts\HelloDialogApiFactoryInterface;
use Czim\HelloDialog\Contracts\HelloDialogApiInterface;
use Czim\HelloDialog\Contracts\HelloDialogHandlerInterface;
use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class HelloDialogHandler implements
    HelloDialogHandlerInterface
{

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
