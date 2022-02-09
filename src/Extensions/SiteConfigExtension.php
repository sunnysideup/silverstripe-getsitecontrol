<?php
namespace Sunnysideup\GetSiteControl\Extensions;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;

class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'GetSiteControlAPI' => 'Varchar(30)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            'Root.GetSiteControl',
            [
                TextField::create(
                    'GetSiteControlAPI',
                    'GetSiteControl API Key'
                )
                    ->setDescription('Add just the key at the end of the link //l.getsitecontrol.com/3w0pvyd7.js, API Key is 3w0pvyd7'),

                LiteralField::create(
                    'GetSiteControlAPIHelp',
                    'Go to: <a target="_blank" href="https://dash.getsitecontrol.com/">GetSiteControl Dashboard</a>'
                ),
            ]
        );
    }
}