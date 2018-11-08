<?php
namespace Arillo\Utils;

use SilverStripe\Forms\FieldList;

/**
 * CMS helper functions.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class CMS
{
    /**
     * Call in getCMSActions to remove campaign related actions.
     *
     * @param  FieldList $actions
     * @return FieldList
     */
    public static function remove_campaign_actions(FieldList $actions)
    {
        if ($field = $actions->fieldByName('ActionMenus.MoreOptions'))
        {
            $field->removeByName('action_addtocampaign');
        }

        return $actions;
    }
}
