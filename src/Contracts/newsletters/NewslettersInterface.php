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

    /**
     * @param string|int    $newsletterId
     * @return array|object    Newsletter object
     * @throws Exception
     */
    public function getNewsletter($newsletterId);

    /**
     * @return array|object    Newsletters array
     * @throws Exception
     */
    public function getNewsletters();
}
