<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/newsletters
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Newsletter-operations
 *
 */

use Czim\HelloDialog\Contracts\newsletters\Newsletter;
use Czim\HelloDialog\Handlers\NewslettersHandler;
require_once('../vendor/autoload.php');
require_once('../src/config/Hellodialog.php');

$newslettersHandler = new NewslettersHandler();

// Get all newsletters
try {
    $newsletters = $newslettersHandler->getNewsletters();
    //print_r($newsletters);
} catch (Exception $e) {
    print_r($e);
}

// Get a single newsletter
try {
    $newsletter = $newslettersHandler->getNewsletter(1);
    //print_r($newsletter);
} catch (Exception $e) {
    print_r($e);
}

// Post a newsletter
try {
    $newsletter = new Newsletter();
    $newsletter->name = 'Test newsletter';
    $newsletter->subject = 'My test subject';
    $newsletter->html = '<html><h2>Test Heading</h2></html>';

    $newsletter = $newslettersHandler->createNewsletter($newsletter);
    print_r($newsletter);
} catch (Exception $e) {
    print_r($e);
}