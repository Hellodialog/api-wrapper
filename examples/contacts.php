<?php
/**
 * THIS IS AN EXAMPLE
 * ----------------------------------------------------------------
 *
 * This is an example of how to use api/contacts
 * Documentation url: https://docs.hellodialog.dev/v1/#tag/Contact-operations
 *
 */

use Hellodialog\ApiWrapper\Contracts\contacts\Contact;
use Hellodialog\ApiWrapper\Handlers\ContactsHandler;
require_once('vendor/autoload.php');
require_once('src/config/Hellodialog.php');

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

// Get all contacts matching your parameters
try {
    $params = ['key' =>'email','value' =>'domainname.com','condition' =>'ends-with'];
    $page = 2;

    // $page is not required
    $contactsByConditions = $contactsHandler->getContactsByParameters($params, $page);
    // print_r($contactsByConditions);
} catch (Exception $e) {
    print($e);
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

// Update multiple contacts
try {
    $contacts = [];
    $contactOne = new Contact();
    $contactOne->achternaam = 'Updated';
    $contacts[] = $contactOne;
    $contactTwo = new Contact();
    $contactTwo->achternaam = 'Updated Another';
    $contacts[] = $contactTwo;
    $result = $contactsHandler->updateContacts($contacts);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}

// Update a single contact
try {
    $contact = new Contact();
    $contact->achternaam = 'Updated';
    $result = $contactsHandler->updateContact(1, (array)$contact);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}

// Delete a contact
try {
    $id = 1;
    $result = $contactsHandler->deleteContact($id);
    //print_r($result);
} catch (Exception $e) {
    print_r($e);
}
