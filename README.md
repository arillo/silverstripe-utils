# Arillo\Utils

[![Latest Stable Version](https://poser.pugx.org/arillo/silverstripe-utils/v/stable?format=flat)](https://packagist.org/packages/arillo/silverstripe-utils)
&nbsp;
[![Total Downloads](https://poser.pugx.org/arillo/silverstripe-utils/downloads?format=flat)](https://packagist.org/packages/arillo/silverstripe-utils)

Utils and helpers for SilverStripe CMS.

### Requirements

SilverStripe CMS ^4.0

## Installation

```bash
composer require arillo/silverstripe-utils
```

## Usage

This module is a bundle of classes to alter functionality in the CMS.

### Arillo\Utils\HiddenLeftAndMain

Attach `Arillo\Utils\HiddenLeftAndMain` to any LeftAndMain subclass you want to hide, e.g. in `config.yml`:

```
SilverStripe\CampaignAdmin\CampaignAdmin:
  extensions:
    - Arillo\Utils\HiddenLeftAndMain
```

### Arillo\Utils\FluentFilteredHelper

If you use `silverstripe-fluent` with `TractorCow\Fluent\Extension\FluentFilteredExtension` you can add `Arillo\Utils\FluentFilteredHelper` to your translated DataObject and it will attach all Locales on record creation and also deletes the related locale records on record deletion. In config, e.g. add:

```
SilverStripe\CMS\Model\SiteTree:
  extensions:
    - 'TractorCow\Fluent\Extension\FluentFilteredExtension'
    - 'Arillo\Utils\FluentFilteredHelper'
```

### Arillo\Utils\CMS

Some unsorted functions (just one for now).
Remove campaign-related actions from Menu:

```
<?php
use SilverStripe\CMS\Model\SiteTree;
use Arillo\Utils\CMS;

class Page extends SiteTree
{
    public function getCMSActions()
    {
        return CMS::remove_campaign_actions(parent::getCMSActions());
    }
}
```

### Arillo\Utils\AlertField

Display a message in CMS (bootstrap alert style). E.g.:

```
<?php
use SilverStripe\CMS\Model\SiteTree;
use Arillo\Utils\AlertField;

class Page extends SiteTree
{
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Main',
            AlertField::create('PageInfo', "Page type: {$this->ClassName}", 'dark')
        , 'Title');
        return $fields;
    }
}
```
