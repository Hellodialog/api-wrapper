<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/login
 * Documentation url: https://docs.hellodialog.dev/v1/#operation/getLogin
 *
 */

use Czim\HelloDialog\Handlers\LoginHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$loginHandler = new LoginHandler();

// Get login url
try {
    $login = $loginHandler->getLogin();
    print_r($login);
} catch (Exception $e) {
    print_r($e);
}