<?php

namespace Hellodialog\ApiWrapper\Contracts\transactional;

use Hellodialog\ApiWrapper\Enums\ContactType;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
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
