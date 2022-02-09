<?php

namespace Sunnysideup\GetSiteControl\Extensions;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\core\Extension;

class PageControllerExtension extends Extension
{

    public function contentcontrollerInit()
    {  
        if (
            ! empty(SiteConfig::current_site_config()->GetSiteControlAPI) &&
            ! $this->owner->IsGetSiteControlPage()
        ) {
            Requirements::javascript(
                '//l.getsitecontrol.com/' . SiteConfig::current_site_config()->GetSiteControlAPI . '.js',
                [
                    'async' => true,
                ]
            );
        }
    }

}
