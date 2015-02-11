<?php

namespace Craft;

class TranslatePlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Translate');
    }

    public function getVersion()
    {
        return '0.3.3';
    }

    public function getDeveloper()
    {
        return 'Bob Olde Hampsink';
    }

    public function getDeveloperUrl()
    {
        return 'http://www.itmundi.nl';
    }

    public function hasCpSection()
    {
        return true;
    }
}
