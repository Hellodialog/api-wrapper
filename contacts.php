<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/contacts
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Contact-operations
 *
 */

use Czim\HelloDialog\Contracts\contacts\Contact;
use Czim\HelloDialog\Handlers\ContactsHandler;
require_once('vendor/autoload.php');
require_once('src/config/hellodialog.php');

$contactsHandler = new ContactsHandler();

// Get all contacts
try {
    $contacts = $contactsHandler->getContacts();
    //print_r($contacts);
} catch (Exception $e) {
    print_r($e);
}

// Get all contacts with the same email
try {
    $contactsByEmail = $contactsHandler->getContactsByEmail("bart@hellodialog.com");
    //print_r($contactsByEmail);
} catch (Exception $e) {
    print_r($e);
}

// Get a single contact
try {
    $contactByEmail = $contactsHandler->getContactByEmail("bart@hellodialog.com");
    //print_r($contactByEmail);
} catch (Exception $e) {
    print_r($e);
}

// Get if email exists
try {
    $contactByEmail = $contactsHandler->checkIfEmailExists("bart@hellodialog.com");
    //print_r($contactByEmail);
} catch (Exception $e) {
    print_r($e);
}

// Post a contact
try {
    $contact = new Contact();
    $contact->voornaam = 'John';
    $contact->achternaam = 'Doe';
    $contact->email = 'test+'.mt_rand(0, 100).'@hellodialog.com';
    $contact->geslacht = 'M';
    $contact->groups = [1];
    $contact->_state = 'Contact';
    //$result = $contactsHandler->createContact($contact);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}

// Post a contact with an external group id
try {
    $contact = new Contact();
    $contact->email = 'test+'.mt_rand(0, 100).'@hellodialog.com';
    $contact->external_group_ids = [1];
    $contact->_state = 'Contact';
    $result = $contactsHandler->createExternalContact($contact);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}