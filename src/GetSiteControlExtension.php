<?php
namespace Sunnysideup\GetSiteControl;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;

class GetSiteControlExtension extends DataExtension
{
    private static $db = [
        'GetSiteControlAPI' => 'Varchar(30)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            "Root.GetSiteControl",
            [
                TextField::create("GetSiteControlAPI", "Get Site Control API Key")
                    ->setDescription(
                        "Add just the key at the end of the link //l.getsitecontrol.com/3w0pvyd7.js, API Key is 3w0pvyd7")
                    ),

                LiteralField::create(
                    'GetSiteControlAPIHelp',
                    "<a target='_blank' href='https://dash.getsitecontrol.com/'>Get site control Dashboard</a>"
                ),
            ]
        );

    }
}