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

If you use `silverstripe-fluent` with `TractorCow\Fluent\Extension\FluentFilteredExtension` you can add `Arillo\Utils\FluentFilteredHelper` to your translated DataObject and it will attach all Locales on record creation and deletes locale entries on record deletion. In config, e.g. add:

```
MyDataObject:
  # will create locale entries for this record on first save, default: true
  auto_create_locales: true

  # will delete locale entries on record deletion, default: false
  auto_delete_locales: true
  extensions:
    - 'TractorCow\Fluent\Extension\FluentFilteredExtension'
    - 'Arillo\Utils\FluentFilteredHelper'
```

### Arillo\Utils\FluentHelper

With `Arillo\Utils\FluentHelper::force_delete` you can improve UX in CMS while record deletion. At the moment Fluent forces you to delete a page in each Locale, to remove it from SiteTree. Example usage:

```
<?php
use SilverStripe\CMS\Model\SiteTree;
use Arillo\Utils\FluentHelper;

class Page extends SiteTree
{
    public function onBeforeDelete()
    {
        parent::onBeforeDelete();
        FluentHelper::force_delete($this); // insert this
    }
}
```

### Arillo\Utils\CMS

Some unsorted functions.

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

Thumbnail helper function for gridfield usage:

```
<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use Arillo\Utils\CMS;

class MyDataObject extends DataObject
{
    private static $has_one = [ 'Image' => Image::class ];
    private static $summary_fields = [ 'Thumbnail' => 'Image' ];

    public function getThumbnail()
    {
        return CMS::thumbnail($this->Image());
    }
}
```

### Arillo\Utils\AlertField

Display a message in CMS ([bootstrap alert style](https://v4-alpha.getbootstrap.com/components/alerts/)). E.g.:

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

### Arillo\Utils\SortableDataObject

Add this extension to a DataObject to make it sortable:

```
use SilverStripe\ORM\DataObject;
use Arillo\Utils\SortableDataObject;

class MyDataObject extends DataObject
{
    private static $extensions = [
        SortableDataObject::class,
    ];
}
```

You can apply `GridFieldOrderableRows` to the managing `GridField` with the following helper function:

```
use Arillo\Utils\SortableDataObject;

...
..
.

SortableDataObject::make_gridfield_sortable($gridField);
```

### Arillo\Utils\Env

There are 3 global helper functions for template usage:

```
Is DEV: <% if $IsDev %>yes<% else %>no<% end_if %> <br>
Is TEST: <% if $IsTest %>yes<% else %>no<% end_if %> <br>
Is PROD: <% if $IsProd %>yes<% else %>no<% end_if %> <br>
```

in php:

```
Arillo\Utils\Env::is_dev();
Arillo\Utils\Env::is_prod();
Arillo\Utils\Env::is_test();
```

### Arillo\Utils\PageHelper

Helper for pages & templates functions.

Adds `PageInstance` and `PageControllerInstance` template methods. Most helpfull in case there should be only one instance of a SiteTree subclass:

```
<%-- access a page by classname in templates --%>
$PageInstance(SomeSiteTreeSubClassName).Title
$PageInstance(SomeSiteTreeSubClassName).Link

<%-- e.g. render a Form from a diffrent controller --%>
$PageControllerInstance(SomeSiteTreeSubClassName).Form
```
