<?php

namespace Czim\HelloDialog\Contracts\ping;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Exception;

interface PingInterface
{
    /**
     * @return array
     */
    public function getPing();
}
