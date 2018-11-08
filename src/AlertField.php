<?php
namespace Arillo\Utils;
use SilverStripe\Forms\LiteralField;

/**
 * Display a message in CMS (bootstrap alert style).
 *
 * @package Arillo
 * @subpackage Utils
 * @author <bumbus sf@arillo.net>
 */
class AlertField extends LiteralField
{
    const TYPES = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'light',
        'dark',
    ];

    protected $type = null;

    /**
     * @param  string $name     field name
     * @param  string $message  message to display
     * @param  string $type     one of self::TYPES to define the style.
     */
    public function __construct(
        string $name,
        string $message,
        string $type = self::TYPES[0]
    ) {
        $this->type = in_array($type, self::TYPES, $type) ? $type : self::TYPES[0];

        parent::__construct($name, $message);

    }

    public function setContent($message)
    {
        $this->content = "<div class='alert alert-{$this->type}'>{$message}</div>";
    }
}
