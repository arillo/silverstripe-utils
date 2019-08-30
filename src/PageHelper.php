<?php
namespace Arillo\Utils;

use SilverStripe\View\TemplateGlobalProvider;
use SilverStripe\CMS\Controllers\ModelAsController;

/**
 * Helper for Pages & templates functions.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */

class PageHelper implements TemplateGlobalProvider
{
    public static function get_template_global_variables()
    {
        return [
            'PageInstance' => [
                'method' => 'page_instance'
            ],
            'PageControllerInstance' => [
                'method' => 'pagecontroller_instance'
            ],
        ];
    }

    /**
     * Find a page instance by classname.
     *
     * @param  string  $pageType
     * @param  boolean $strict   strict mode disables inheritance
     * @return SiteTree|null
     */
    public static function page_instance(
        string $pageType,
        bool $strict = true
    ) {
        $page = null;
        $filter = [];
        if ($strict) $filter['ClassName'] = $pageType;

        if (class_exists($pageType) && ($page = $pageType::get()->filter($filter)) && $page->exists())
        {
          return $page->first();
        }

        return null;
    }

    /**
     * Get a controller instance by Page classname.
     *
     * @param  string  $pageType
     * @param  boolean $strict   strict mode disables inheritance
     * @return Controller|null
     */
    public static function pagecontroller_instance(
        string $pageType,
        bool $strict = true
    ) {
        if ($page = self::page_instance($pageType, $strict))
        {
            return ModelAsController::controller_for($page);
        }

        return null;
    }
}
