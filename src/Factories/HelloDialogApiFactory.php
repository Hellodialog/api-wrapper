<?php
namespace Hellodialog\ApiWrapper\Factories;

use Hellodialog\ApiWrapper\Contracts\HelloDialogApiFactoryInterface;
use Hellodialog\ApiWrapper\Contracts\HelloDialogApiInterface;
use Hellodialog\ApiWrapper\HelloDialogApi;

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
