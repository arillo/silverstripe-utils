<?php
namespace Arillo\Utils;

use SilverStripe\Core\Extension;

/**
 * Hide unwanted LeftAndMain in CMS.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class HiddenLeftAndMain extends Extension
{
    public function alternateAccessCheck($member = null)
    {
        return false;
    }
}
