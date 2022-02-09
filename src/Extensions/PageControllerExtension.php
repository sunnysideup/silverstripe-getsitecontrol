<?php
namespace Sunnysideup\GetSiteControl\Extensions;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;

class PageControllerExtension extends Extension
{

    public function contentcontrollerInit()
    {
        if (
            !empty(SiteConfig::current_site_config()->GetSiteControlAPI) &&
            $this->IsGetSiteControlPage()
        ) {
            Requirements::javascript(
                '//l.getsitecontrol.com/'.SiteConfig::current_site_config()->GetSiteControlAPI.'.js',
                [
                    'async' => true
                ]
            );
        }

    }

    private function IsGetSiteControlPage() : bool
    {
        return $this->getOwner()->IsGetSiteControlEnabledOnPageLevel() && $this->getOwner()->ActiveGetSiteControl;
    }

}