<?php

namespace Hellodialog\ApiWrapper\Contracts\statistics;

use Hellodialog\ApiWrapper\Exceptions\HelloDialogErrorException;
use Hellodialog\ApiWrapper\Exceptions\HelloDialogGeneralException;
use Exception;

interface StatisticsInterface
{

    /**
     * @return array
     */
    public function getStatistics();

    /**
     * @return array
     */
    public function getContactsStatistics();

    /**
     * @param $campaignId
     * @return array
     */
    public function getCampaignStatistics($campaignId);
}
