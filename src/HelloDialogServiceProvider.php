<?php
namespace Hellodialog\ApiWrapper;

use Hellodialog\ApiWrapper\Contracts\contacts\ContactsInterface;
use Hellodialog\ApiWrapper\Contracts\fields\FieldsInterface;
use Hellodialog\ApiWrapper\Contracts\groups\GroupsInterface;
use Hellodialog\ApiWrapper\Contracts\HelloDialogApiFactoryInterface;
use Hellodialog\ApiWrapper\Contracts\HelloDialogHandlerInterface;
use Hellodialog\ApiWrapper\Contracts\lists\ListsInterface;
use Hellodialog\ApiWrapper\Contracts\login\LoginInterface;
use Hellodialog\ApiWrapper\Contracts\newsletters\NewslettersInterface;
use Hellodialog\ApiWrapper\Contracts\orders\OrdersInterface;
use Hellodialog\ApiWrapper\Contracts\ping\PingInterface;
use Hellodialog\ApiWrapper\Contracts\statistics\StatisticsInterface;
use Hellodialog\ApiWrapper\Contracts\transactional\TransactionalInterface;
use Hellodialog\ApiWrapper\Factories\HelloDialogApiFactory;
use Hellodialog\ApiWrapper\Handlers\ContactsHandler;
use Hellodialog\ApiWrapper\Handlers\FieldsHandler;
use Hellodialog\ApiWrapper\Handlers\GroupsHandler;
use Hellodialog\ApiWrapper\Handlers\ListsHandler;
use Hellodialog\ApiWrapper\Handlers\LoginHandler;
use Hellodialog\ApiWrapper\Handlers\NewslettersHandler;
use Hellodialog\ApiWrapper\Handlers\OrdersHandler;
use Hellodialog\ApiWrapper\Handlers\PingHandler;
use Hellodialog\ApiWrapper\Handlers\StatisticsHandler;
use Hellodialog\ApiWrapper\Handlers\TransactionalHandler;
use Hellodialog\ApiWrapper\Mail\HelloDialogTransport;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HelloDialogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerHelloDialogMailDriver();
    }

    public function register()
    {
        $this->registerHelloDialogInterfaces();
    }

    /**
     * Registers Hello Dialog class interfaces
     */
    protected function registerHelloDialogInterfaces()
    {
        $this->app->bind(HelloDialogApiFactoryInterface::class, HelloDialogApiFactory::class);
        $this->app->bind(HelloDialogHandlerInterface::class, HelloDialogHandler::class);
        $this->app->bind(ContactsInterface::class, ContactsHandler::class);
        $this->app->bind(GroupsInterface::class, GroupsHandler::class);
        $this->app->bind(FieldsInterface::class, FieldsHandler::class);
        $this->app->bind(ListsInterface::class, ListsHandler::class);
        $this->app->bind(LoginInterface::class, LoginHandler::class);
        $this->app->bind(NewslettersInterface::class, NewslettersHandler::class);
        $this->app->bind(OrdersInterface::class, OrdersHandler::class);
        $this->app->bind(PingInterface::class, PingHandler::class);
        $this->app->bind(StatisticsInterface::class, StatisticsHandler::class);
        $this->app->bind(TransactionalInterface::class, TransactionalHandler::class);
    }

    /**
     * Registers a custom mail driver with the transport manager
     */
    protected function registerHelloDialogMailDriver()
    {
        list($major, $minor) = $this->getLaravelVersion();

        // Laravel needs to be at least version 5.2 for the swift.transport extension
        if (($major == 5 && $minor <= 1) ||  $major < 5) {
            return;
        }

        $this->app['swift.transport']->extend(
            'hellodialog',
            $this->app->share(function ($app) {
                $handler = $app->make(HelloDialogHandlerInterface::class);
                return new HelloDialogTransport($handler);
            })
        );
    }

    /**
     * Returns version of Laravel application.
     *
     * @return array
     */
    private function getLaravelVersion()
    {
        preg_match('#^(?<major>\d+)\.(?<minor>\d+)(?:\..*)?$#', Application::VERSION, $matches);

        $major = (int) $matches['major'];
        $minor = (int) $matches['minor'];

        return [ $major, $minor ];
    }
}
