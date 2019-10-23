<?php

namespace Czim\HelloDialog\Contracts\statistics;

use Czim\HelloDialog\Exceptions\HelloDialogErrorException;
use Czim\HelloDialog\Exceptions\HelloDialogGeneralException;
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
