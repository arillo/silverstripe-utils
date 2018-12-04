<?php
namespace Arillo\Utils;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBField;

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

    /**
     * Thumbnail for gridfield usage
     * @param  Image  $image
     * @param  int  $width
     * @param  int  $height
     * @return DBField
     */
    public static function cms_thumbnail(
        Image $image,
        int $width = 90,
        int $height = 90
    ) {
        if ($image && $image->exists())
        {
            return DBField::create_field(
                'HTMLText',
                "<img src='{$image->Fill($width, $height)->getURL()}' />"
            );
        }
        return '[no image]';
    }
}
