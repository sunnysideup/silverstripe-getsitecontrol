<?php

namespace Sunnysideup\GetSiteControl\Extensions;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
//todo: add Extension use statement

class PageControllerExtension extends Extension
{
    public function onAfterInit()
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

    public function IsGetSiteControlPage(): bool
    {
        if ($this->getOwner()->hasMethod('IsGetSiteControlEnabledOnPageLevelOverride')) {
            return $this->getOwner()->IsGetSiteControlEnabledOnPageLevelOverride();
        }
        return
            $this->getOwner()->IsGetSiteControlEnabledOnPageLevel() &&
            $this->getOwner()->dataRecord->ActiveGetSiteControl
        ;
    }
}
