<?php
namespace Czim\HelloDialog\Enums;

use MyCLabs\Enum\Enum;

/**
 * Unique identifiers for standard Criteria that may be loaded in repositories.
 */
class ContactType extends Enum
{
    const CONTACT      = 'Contact';
    const OPT_IN       = 'Optin';
    const UNSUBSCRIBER = 'Unsubscriber';
    const BOUNCED      = 'Bounced';
}
