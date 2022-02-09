<?php

namespace Sunnysideup\GetSiteControl\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\Core\Config\Config;

class PageExtension extends SiteTreeExtension
{
    private static $db = [
        'ActiveGetSiteControl' => 'Boolean(1)',
    ];

    /**
     * list of clasess to be explicityly included
     * to avoid including all by default.
     *
     * @var array
     */
    private static $page_classes_included_from_get_site_control = [];

    /**
     * list of clasess to be excluded.
     *
     * @var array
     */
    private static $page_classes_excluded_from_get_site_control = [
        ErrorPage::class,
        RedirectorPage::class,
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
        $included = Config::inst()->get(PageExtension::class, 'page_classes_included_from_get_site_control');
        if(! empty($included)) {
            foreach($included as $className) {
                if($this instanceof $className) {
                    return true;
                }
            }
            return false;
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
