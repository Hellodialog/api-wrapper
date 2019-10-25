<?php

namespace Hellodialog\ApiWrapper\Contracts\campaigns;

use Hellodialog\ApiWrapper\Enums\ContactType;
use Exception;

interface CampaignsInterface
{

    /**
     * @param string|int    $campaignId
     * @return array|object    Campaign object
     * @throws Exception
     */
    public function getCampaign($campaignId);

    /**
     * @return array|object    Campaigns array
     * @throws Exception
     */
    public function getCampaigns();

    /**
     * @param $fields
     * @return array
     * @throws Exception
     */
    public function createCampaign($fields);
}
