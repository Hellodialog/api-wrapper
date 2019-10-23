<?php

namespace Czim\HelloDialog\Contracts\campaigns;

use Czim\HelloDialog\Enums\ContactType;
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
}
