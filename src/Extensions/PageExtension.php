<?php

namespace Sunnysideup\GetSiteControl\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
//todo: add ErrorPage use statement

class PageExtension extends SiteTreeExtension
{
    private static $db = [
        'ActiveGetSiteControl' => 'Boolean(1)',
    ];

    /**
     * list of clasess to be excluded.
     *
     * @var array
     */
    private static $page_classes_excluded_from_get_site_control = [
        ErrorPage::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        // Add get site control field only if is Published or can Publish
        $a = ($this->getOwner()->isPublished() && $this->getOwner()->isOnDraft());
        $b = $this->getOwner()->canPublish();
        if ($a || $b) {
            $fields->addFieldToTab(
                'Root.GetSiteControl',
                CheckboxField::create('ActiveGetSiteControl', 'Use GetSiteControl')
            );
        }
    }

    public function IsGetSiteControlPage(): bool
    {
        return $this->getOwner()->IsGetSiteControlEnabledOnPageLevel() && $this->getOwner()->ActiveGetSiteControl;
    }

    public function IsGetSiteControlEnabledOnPageLevel(): bool
    {
        if ($this->getOwner()->hasMethod('IsGetSiteControlEnabledOnPageLevelOverride')) {
            return $this->getOwner()->hasMethod('IsGetSiteControlEnabledOnPageLevelOverride');
        }
        $excluded = Config::inst()->get(PageExtension::class, 'page_classes_excluded_from_get_site_control');
        foreach($excluded as $className) {
            if($this instanceof $className) {
                return false;
            }
        }
        return true;
    }
}
