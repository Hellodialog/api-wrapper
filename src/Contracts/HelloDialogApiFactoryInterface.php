<?php
namespace Hellodialog\ApiWrapper\Contracts;

interface HelloDialogApiFactoryInterface
{

    /**
     * Makes a new HelloDialogApi instance.
     *
     * @param string $type
     * @return HelloDialogApiInterface
     */
    public function make($type);

}
