<?php

namespace Czim\HelloDialog\Contracts\transactional;

use Czim\HelloDialog\Enums\ContactType;
use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Exception;

interface TransactionalInterface
{
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
    public function transactional($to, $subject, $template = null, array $from = null, array $replaces = [], $replyToMail = null);
}
