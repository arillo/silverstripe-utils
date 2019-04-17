<?php
namespace Arillo\Utils;

use TractorCow\Fluent\Model\Locale;
use SilverStripe\ORM\DataExtension;

use SilverStripe\ORM\Queries\SQLDelete;
use SilverStripe\ORM\DataObject;
use TractorCow\Fluent\Extension\FluentExtension;

/**
 * Asorted helper function for Fluent
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class FluentHelper
{
    /**
     * Deletes <TABLE>_Localised_Live and <TABLE>_Localised entries for a given record.
     *
     * @param  DataObject $record
     * @param  bool $deleteVersioned    shall versions entries also be deleted
     * @return DataObject
     */
    public static function force_delete(
        DataObject $record,
        $deleteVersioned = true
    ) {
        foreach ($record->getLocalisedTables() as $table => $value)
        {
            $tables = [
                $table . '_' . FluentExtension::SUFFIX,
            ];

            if ($deleteVersioned)
            {
                $tables[] = $table . '_' . FluentExtension::SUFFIX . '_Live';
            }

            foreach ($tables as $deleteTable)
            {
                SQLDelete::create("\"{$deleteTable}\"")
                    ->addWhere(["\"{$deleteTable}\".\"RecordID\"" => $record->ID])
                    ->execute()
                ;
            }
        }
        return $record;
    }
}
