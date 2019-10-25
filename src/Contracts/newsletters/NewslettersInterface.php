<?php

namespace Hellodialog\ApiWrapper\Contracts\newsletters;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
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

    /**
     * @param Newsletter $fields
     * @return mixed
     */
    public function createNewsletter($fields);
}
