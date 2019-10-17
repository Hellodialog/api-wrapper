<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\transactional\TransactionalInterface;
use Czim\HelloDialog\Enums\ContactType;
use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class TransactionalHandler extends HelloDialogHandler implements TransactionalInterface
{
    const API_TRANSACTIONAL = 'transactional';

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
}