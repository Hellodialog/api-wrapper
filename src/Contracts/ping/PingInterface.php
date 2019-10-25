<?php

namespace Hellodialog\ApiWrapper\Contracts\ping;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
use Exception;

interface PingInterface
{
    /**
     * @return array
     */
    public function getPing();
}
