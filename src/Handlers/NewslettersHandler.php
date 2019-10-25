<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\newsletters\Newsletter;
use Hellodialog\ApiWrapper\Contracts\newsletters\NewslettersInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class NewslettersHandler extends HelloDialogHandler implements NewslettersInterface
{
    const API_NEWSLETTERS   = 'newsletters';

    /**
     * Fetches the contents of a template, optionally performing placeholder replaces.
     *
     * @param int   $templateId
     * @param array $replaces
     * @return string
     */
    public function getTemplateContents($templateId, array $replaces = [])
    {
        $result = $this->getApiInstance(static::API_NEWSLETTERS)->get($templateId);

        $this->checkForHelloDialogError($result);

        $result = $result['html'];

        if (count($replaces)) {
            $result = str_replace(array_keys($replaces), array_values($replaces), $result);
        }

        return $result;
    }

    /**
     * @param string|int $newsletterId
     * @return array|object    Newsletter object
     * @throws Exception
     */
    public function getNewsletter($newsletterId)
    {
        $call = $this->getApiInstance(static::API_NEWSLETTERS.'/'.$newsletterId);

        return $call->get() ?: [];
    }

    /**
     * @return array|object    Newsletters array
     * @throws Exception
     */
    public function getNewsletters()
    {
        $call = $this->getApiInstance(static::API_NEWSLETTERS);

        return $call->get() ?: [];
    }

    /**
     * @param Newsletter $fields
     * @return mixed
     * @throws Exception
     */
    public function createNewsletter($fields)
    {
        $call = $this->getApiInstance(static::API_NEWSLETTERS)->data((array)$fields);

        return $call->post() ?: [];
    }
}