<?php
namespace Sunnysideup\GetSiteControl;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

class GetSiteControl extends DataExtension
{
    private static $db = [
        'ActiveGetSiteControl' => 'Boolean(1)'
    ];

    /**
     * list of clasess to be excluded
     * @var array
     */
    private static $page_classes_excluded_from_get_site_control = [
        ErrorPage::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        // Add get site control field only if is Publish and can Publish
        $a = ($this->owner->isPublished() && $this->owner->isOnDraft());
        $b = $this->owner->canPublish();
        if ($a || $b) {
            $fields->addFieldToTab(
                "Root.GetSiteControl",
                CheckboxField::create("ActiveGetSiteControl", "Use GetSiteControl")
            );
        }
    }

    public function IsGetSiteControlEnabledOnPageLevel() : bool
    {
        if($this->getOwner()->hasMethod('IsGetSiteControlEnabledOnPageLevelOverride')) {
            return $this->getOwner()->hasMethod('IsGetSiteControlEnabledOnPageLevelOverride');
        }
        return in_array($this->getOwner()->ClassName, Config::inst()->get(GetSiteControl::class, 'page_classes_excluded_from_get_site_control'))
    }

}