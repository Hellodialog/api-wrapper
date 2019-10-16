<?php
namespace Czim\HelloDialog\Factories;

use Czim\HelloDialog\Contracts\HelloDialogApiFactoryInterface;
use Czim\HelloDialog\Contracts\HelloDialogApiInterface;
use Czim\HelloDialog\HelloDialogApi;

class HelloDialogApiFactory implements HelloDialogApiFactoryInterface
{

    /**
     * Makes a new HelloDialogApi instance.
     *
     * @param string $type
     * @return HelloDialogApiInterface
     */
    public function make($type)
    {
        $api = app(HelloDialogApi::class);

        $api->setType($type);

        return $api;
    }

}
