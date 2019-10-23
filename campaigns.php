<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/campaigns
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Campaign-operations
 *
 */

use Czim\HelloDialog\Handlers\CampaignsHandler;
require_once('vendor/autoload.php');
array_merge(require_once('src/config/app.php'), require_once('src/config/hellodialog.php'));

$campaignsHandler = new CampaignsHandler();

// Get all campaigns
try {
    $campaigns = $campaignsHandler->getCampaigns();
    print_r($campaigns);
} catch (Exception $e) {
    print_r($e);
}