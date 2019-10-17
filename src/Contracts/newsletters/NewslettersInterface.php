<?php

namespace Czim\HelloDialog\Contracts\newsletters;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
use Exception;

interface NewslettersInterface
{
    /**
     * Fetches the contents of a template, optionally performing placeholder replaces.
     *
     * @param int   $templateId
     * @param array $replaces
     * @return string
     */
    public function getTemplateContents($templateId, array $replaces = []);
}
