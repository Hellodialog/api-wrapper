<?php
require_once('vendor/autoload.php');
require_once('src/config/app.php');

use Czim\HelloDialog\Handlers\OrdersHandler;
use Czim\HelloDialog\Handlers\PingHandler;
use Czim\HelloDialog\Handlers\StatisticsHandler;
use Czim\HelloDialog\Handlers\CampaignsHandler;
use \Czim\HelloDialog\Handlers\ContactsHandler;
use Czim\HelloDialog\Handlers\FieldsHandler;
use Czim\HelloDialog\Handlers\GlobalHandler;
use Czim\HelloDialog\Handlers\GroupsHandler;
use Czim\HelloDialog\Handlers\ListsHandler;
use Czim\HelloDialog\Handlers\LoginHandler;
use Czim\HelloDialog\Handlers\NewslettersHandler;
use Czim\HelloDialog\Handlers\TransactionalHandler;

echo 'test';

$globalHandler = new GlobalHandler();
//$globalHandler->contacts->getContacts();
try {
    $groups = $globalHandler->groups->getGroups();
    var_dump($groups);
} catch (Exception $e) {
    print_r($e);
}

/*$globalHandler->transactional->transactional();
$globalHandler->campaigns;
$globalHandler->fields;
$globalHandler->lists;
$globalHandler->login;
$globalHandler->newsletters;
$globalHandler->orders;
$globalHandler->ping;
$globalHandler->statistics;*/

/*
$campaignsHandler = new CampaignsHandler();
$contactsHandler = new ContactsHandler();
$groupsHandler = new GroupsHandler();
$fieldsHandler = new FieldsHandler();
$listsHandler = new ListsHandler();
$loginHandler = new LoginHandler();
$newslettersHandler = new NewslettersHandler();
$ordersHandler = new OrdersHandler();
$pingHandler = new PingHandler();
$statisticsHandler = new StatisticsHandler();
$transactionalHandler = new TransactionalHandler();

$contactsHandler->createContact();
$transactionalHandler->transactional();

$campaignsHandler;
$groupsHandler;
$fieldsHandler;
$listsHandler;
$loginHandler;
$newslettersHandler;
$ordersHandler;
$pingHandler;
$statisticsHandler;*/