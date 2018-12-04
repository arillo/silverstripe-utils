<?php
namespace Arillo\Utils;

use SilverStripe\Core\Environment;
use SilverStripe\View\TemplateGlobalProvider;

/**
 * environment helper functions.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class Env implements TemplateGlobalProvider
{
    public static function get_template_global_variables()
    {
        return [
            'IsDev' => [
                'method' => 'is_dev',
            ],
            'IsTest' => [
                'method' => 'is_test',
            ],
            'IsProd' => [
                'method' => 'is_prod',
            ],
        ];
    }

    /**
     * @return boolean
     */
    public static function is_dev()
    {
        return Environment::getEnv('SS_ENVIRONMENT_TYPE') == 'dev';
    }

    /**
     * @return boolean
     */
    public static function is_prod()
    {
        return Environment::getEnv('SS_ENVIRONMENT_TYPE') == 'live';
    }

    /**
     * @return boolean
     */
    public static function is_test()
    {
        return Environment::getEnv('SS_ENVIRONMENT_TYPE') == 'test';
    }
}
