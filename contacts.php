<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/contacts
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Contact-operations
 *
 */

use Czim\HelloDialog\Handlers\ContactsHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$contactsHandler = new ContactsHandler();

// Get account data
try {
    $contactsByEmail = $contactsHandler->getContactsByEmail("bart@hellodialog.com");
    $contacts = $contactsHandler->getContacts();
    print_r($contactsByEmail);
    print_r($contacts);
} catch (Exception $e) {
    print_r($e);
}