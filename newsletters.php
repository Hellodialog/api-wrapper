<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/newsletters
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Newsletter-operations
 *
 */

use Czim\HelloDialog\Handlers\NewslettersHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$newslettersHandler = new NewslettersHandler();

// Get all newsletters
try {
    $newsletters = $newslettersHandler->getNewsletters();
    print_r($newsletters);
} catch (Exception $e) {
    print_r($e);
}