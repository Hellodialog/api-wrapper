<?php

namespace Czim\HelloDialog\Contracts\login;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Exception;

interface LoginInterface
{
    /**
     * @return array
     */
    public function getLogin();
}
