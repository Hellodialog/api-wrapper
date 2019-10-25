<?php

namespace Hellodialog\ApiWrapper\Contracts\login;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
use Exception;

interface LoginInterface
{
    /**
     * @return array
     */
    public function getLogin();
}
