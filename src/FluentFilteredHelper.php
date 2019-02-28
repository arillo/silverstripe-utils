<?php
namespace Arillo\Utils;

use TractorCow\Fluent\Model\Locale;

use SilverStripe\ORM\{
    DataObject,
    DataExtension
};

use SilverStripe\Forms\{
    FieldList,
    CheckboxSetField
};

/**
 * Automatically addes fluent locales on object creation and deletes them
 * on object deletion.
 * Should only be applied to objects using FluentFiltedExtension.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class FluentFilteredHelper extends DataExtension
{
    protected $wasNew = false;

    /**
     * Replace locales grid field with a CheckboxSetField and adds it into main tab.
     * Will display a warning in case no locales are set.
     *
     * @param  DataObject $record
     * @param  FieldList  $fields
     * @param  string     $insertAfter
     * @return FieldList
     */
    public static function replace_locales_manager(
        DataObject $record,
        FieldList $fields,
        string $insertAfter = 'Title'
    ) {
        $fields->removeByName('Locales');
        $fields->insertAfter(
            $insertAfter,
            CheckboxSetField::create(
                'FilteredLocales',
                _t(__CLASS__ . '.Locales', 'Availability'),
                Locale::get()
            )
                ->setDescription(
                    !$record->FilteredLocales()->exists()
                        ? AlertField::create(
                            'NoFilteredLocalesInfo',
                            _t(
                                __CLASS__ . '.NoFilteredLocalesInfo',
                                'Attention, no locales set! This entry is only visible if one or more locales are set.'
                            ),
                            'danger'
                        )->forTemplate()
                        : null
                )
        );

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->wasNew = !$this->owner->isInDB();
    }

    public function updateCMSFields(FieldList $fields)
    {
        self::replace_locales_manager($this->owner, $fields);
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        if ($this->wasNew)
        {
            foreach (Locale::getCached() as $locale)
            {
                $this->owner->FilteredLocales()->add($locale);
            }
        }
    }

    public function onAfterDelete()
    {
        parent::onAfterDelete();
        foreach (Locale::getCached() as $locale)
        {
            $this->owner->FilteredLocales()->remove($locale);
        }
    }
}
