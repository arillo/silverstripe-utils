<?php
namespace Arillo\Utils;

use TractorCow\Fluent\Model\Locale;
use SilverStripe\ORM\DataExtension;

/**
 * Automatically addes fluent locales on object creation and deletes them
 * on object deletion.
 * Should only be applied to objects using FlientFiltedExtension.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class FluentFilteredHelper extends DataExtension
{
    protected $wasNew = false;

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->wasNew = !$this->owner->isInDB();
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
