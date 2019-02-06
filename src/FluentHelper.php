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
    public static function force_delete(DataObject $record)
    {
        foreach ($record->getLocalisedTables() as $table => $value)
        {
            $tables = [
                $table . '_' . FluentExtension::SUFFIX . '_Live',
                $table . '_' . FluentExtension::SUFFIX,
            ];

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
