<?php
namespace Arillo\Utils;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Extension for DataObject classes, adds a Sort field.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class SortableDataObject extends DataExtension
{
    const SORT_FIELD = 'Sort';

    private static
        $db = [
            self::SORT_FIELD => 'Int'
        ]
    ;

    /**
     * Add GridFieldOrderableRows to a GridField.
     *
     * @param  GridField $gridField
     * @param  string    $sortField
     * @return GridField
     */
    public static function make_gridfield_sortable(
        GridField $gridField,
        string $sortField = self::SORT_FIELD
    ) {
        $gridField
            ->getConfig()
            ->addComponent(new GridFieldOrderableRows($sortField))
        ;

        return $gridField;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(self::SORT_FIELD);
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (!$this->owner->Sort)
        {
            $class = get_class($this->owner);
            $this->owner->Sort = $class::get()->max(self::SORT_FIELD) + 1;
        }
    }
}
