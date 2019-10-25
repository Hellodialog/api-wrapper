<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/statistics
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Statistics-operations
 *
 */

use Czim\HelloDialog\Handlers\StatisticsHandler;
require_once('../vendor/autoload.php');
require_once('../src/config/Hellodialog.php');

$statisticsHandler = new StatisticsHandler();

// Get all statistics
try {
    $statistics = $statisticsHandler->getStatistics();
    $statistics = $statisticsHandler->getContactsStatistics();
    $statistics = $statisticsHandler->getCampaignStatistics(5);
    print_r($statistics);
} catch (Exception $e) {
    print_r($e);
}