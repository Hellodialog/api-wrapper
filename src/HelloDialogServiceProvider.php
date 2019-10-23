<?php
namespace Czim\HelloDialog;

use Czim\HelloDialog\Contracts\contacts\ContactsInterface;
use Czim\HelloDialog\Contracts\fields\FieldsInterface;
use Czim\HelloDialog\Contracts\groups\GroupsInterface;
use Czim\HelloDialog\Contracts\HelloDialogApiFactoryInterface;
use Czim\HelloDialog\Contracts\HelloDialogHandlerInterface;
use Czim\HelloDialog\Contracts\lists\ListsInterface;
use Czim\HelloDialog\Contracts\login\LoginInterface;
use Czim\HelloDialog\Contracts\newsletters\NewslettersInterface;
use Czim\HelloDialog\Contracts\orders\OrdersInterface;
use Czim\HelloDialog\Contracts\ping\PingInterface;
use Czim\HelloDialog\Contracts\statistics\StatisticsInterface;
use Czim\HelloDialog\Contracts\transactional\TransactionalInterface;
use Czim\HelloDialog\Factories\HelloDialogApiFactory;
use Czim\HelloDialog\Handlers\ContactsHandler;
use Czim\HelloDialog\Handlers\FieldsHandler;
use Czim\HelloDialog\Handlers\GroupsHandler;
use Czim\HelloDialog\Handlers\ListsHandler;
use Czim\HelloDialog\Handlers\LoginHandler;
use Czim\HelloDialog\Handlers\NewslettersHandler;
use Czim\HelloDialog\Handlers\OrdersHandler;
use Czim\HelloDialog\Handlers\PingHandler;
use Czim\HelloDialog\Handlers\StatisticsHandler;
use Czim\HelloDialog\Handlers\TransactionalHandler;
use Czim\HelloDialog\Mail\HelloDialogTransport;
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
