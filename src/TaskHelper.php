<?php
namespace Arillo\Utils;

use SilverStripe\Control\Director;

/**
 * (Build-) Task helper functions.
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */

class TaskHelper
{
    /**
     * Appends linebreak to a string, depending on how the Task is run (CLI or browser).
     *
     * @param  string $message
     * @return string
     */
    public static function output_line(string $message)
    {
        switch (true)
        {
            case Director::is_cli():
                $message .= PHP_EOL;
                break;

            default:
                $message .= '<br>';
                break;
        }

        echo $message;
    }
}
