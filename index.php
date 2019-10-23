<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use multiple API endpoints at once.
 * Documentation url: https://docs.hellodialog.dev/v1/
 *
 */

use Czim\HelloDialog\Handlers\GlobalHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$globalHandler = new GlobalHandler();

// All calls
try {

    // Contacts
    /*
    $contactsByEmail = $globalHandler->contacts->getContactsByEmail("bart@hellodialog.com");
    $contacts = $globalHandler->contacts->getContacts();
    print_r($contactsByEmail);
    print_r($contacts);
    */

    // Groups
    /*
    $groups = $globalHandler->groups->getGroups();
    print_r($groups);
    */

    // Lists
    /*
    $lists = $globalHandler->lists->getLists();
    print_r($lists);
    */

    // Campaigns
    /*
    $campaigns = $globalHandler->campaigns->getCampaigns();
    print_r($campaigns);
    */

    // Newsletters
    /*
    $newsletters = $globalHandler->newsletters->getNewsletters();
    print_r($newsletters);
    */

    // Fields
    /*
    $fields = $globalHandler->fields->getFields();
    print_r($fields);
    */

    // Order
    /*
    $order = $globalHandler->orders->getOrder(0);
    print_r($order);
    */

    // Statistics
    /*
    $statistics = $globalHandler->statistics->getStatistics();
    $statistics = $globalHandler->statistics->getContactsStatistics();
    $statistics = $globalHandler->statistics->getCampaignStatistics(5);
    print_r($statistics);
    */

    // Login
    /*
    $login = $globalHandler->login->getLogin();
    print_r($login);
    */

    // Ping
    /*
    $ping = $globalHandler->ping->getPing();
    print_r($ping);
    */

    // Transactional
    /*
    $transactional = $globalHandler->transactional->transactional("bart@hellodialog.com", "Test");
    print_r($transactional);
    */

} catch (Exception $e) {
    print_r($e);
}