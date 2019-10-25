<?php
namespace Hellodialog\ApiWrapper\Enums;

use MyCLabs\Enum\Enum;

class ApiType extends Enum
{
    const CONTACTS      = 'contacts';
    const NEWSLETTERS   = 'newsletter';
    const TRANSACTIONAL = 'transactional';
}
