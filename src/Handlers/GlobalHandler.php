<?php
namespace Czim\HelloDialog\Handlers;

use Psr\Log\LoggerInterface;

/**
 * @property TransactionalHandler transactional
 * @property ContactsHandler contacts
 * @property CampaignsHandler campaigns
 * @property FieldsHandler fields
 * @property GroupsHandler groups
 * @property ListsHandler lists
 * @property LoginHandler login
 * @property OrdersHandler orders
 * @property PingHandler ping
 * @property StatisticsHandler statistics
 * @property NewslettersHandler newsletters
 */
class GlobalHandler {

    public function __construct()
    {
        $this->contacts = new ContactsHandler();
        $this->transactional = new TransactionalHandler();
        $this->campaigns = new CampaignsHandler();
        $this->fields = new FieldsHandler();
        $this->groups = new GroupsHandler();
        $this->lists = new ListsHandler();
        $this->login = new LoginHandler();
        $this->orders = new OrdersHandler();
        $this->ping = new PingHandler();
        $this->statistics = new StatisticsHandler();
        $this->newsletters = new NewslettersHandler();
    }
}