<?php
namespace Hellodialog\ApiWrapper\Handlers;

use Hellodialog\ApiWrapper\Contracts\campaigns\CampaignsInterface;
use Hellodialog\ApiWrapper\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class CampaignsHandler extends HelloDialogHandler implements CampaignsInterface
{
    const API_CAMPAIGNS      = 'campaigns';

    /**
     * @param string|int $campaignId
     * @return array|object    Campaign object
     * @throws Exception
     */
    public function getCampaign($campaignId)
    {
        $call = $this->getApiInstance(static::API_CAMPAIGNS.'/'.$campaignId);

        return $call->get() ?: [];
    }

    /**
     * @return array|object    Campaigns array
     * @throws Exception
     */
    public function getCampaigns()
    {
        $call = $this->getApiInstance(static::API_CAMPAIGNS);

        return $call->get() ?: [];
    }

    /**
     * @param $fields
     * @return array
     * @throws Exception
     */
    public function createCampaign($fields)
    {
        $call = $this->getApiInstance(static::API_ORDERS)->data((array)$fields);

        return $call->post() ?: [];
    }
}