<?php
/**
 * Class Contact
 * @package Hellodialog\ApiWrapper\Contracts\contacts
 */
namespace Hellodialog\ApiWrapper\Contracts\contacts;

class Contact {

    /*
     * E-mailaddress
     */
    public $email;

    /*
     * First name
     */
    public $voornaam;

    /*
     * Last name
     */
    public $achternaam;

    /*
     * Gender
     */
    public $geslacht;

    /*
     * Groups
     */
    public $groups;

    /*
     * External Groups
     */
    public $external_group_ids;

    /*
     * State
     */
    public $_state;

}