<?php

namespace Sunnysideup\GetSiteControl\Extensions;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

class PageControllerExtension extends Extension
{
    public function contentcontrollerInit()
    {
        if (
            ! empty(SiteConfig::current_site_config()->GetSiteControlAPI) &&
            $this->IsGetSiteControlPage()
        ) {
            Requirements::javascript(
                '//l.getsitecontrol.com/' . SiteConfig::current_site_config()->GetSiteControlAPI . '.js',
                [
                    'async' => true,
                ]
            );
        }
    }

    private function IsGetSiteControlPage(): bool
    {
        return $this->getOwner()->IsGetSiteControlEnabledOnPageLevel() && $this->getOwner()->ActiveGetSiteControl;
    }
}
