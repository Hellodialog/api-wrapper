<?php
namespace Czim\HelloDialog\Handlers;

use Czim\HelloDialog\Contracts\statistics\StatisticsInterface;
use Czim\HelloDialog\HelloDialogHandler;
use Exception;
use Log;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

class StatisticsHandler extends HelloDialogHandler implements StatisticsInterface
{
    const API_STATISTICS      = 'statistics';

    /**
     * @return array
     * @throws Exception
     */
    public function getStatistics()
    {
        $call = $this->getApiInstance(static::API_STATISTICS);

        return $call->get() ?: [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getContactsStatistics()
    {
        $call = $this->getApiInstance(static::API_STATISTICS.'/contacts/');

        return $call->get() ?: [];
    }

    /**
     * @param $campaignId
     * @return array
     * @throws Exception
     */
    public function getCampaignStatistics($campaignId)
    {
        $call = $this->getApiInstance(static::API_STATISTICS.'/campaign/'.$campaignId);

        return $call->get() ?: [];
    }
}