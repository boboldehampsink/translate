<?php

namespace Craft;

class TranslatePlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Translate');
    }

    function getVersion()
    {
        return '0.3.3';
    }

    function getDeveloper()
    {
        return 'Bob Olde Hampsink';
    }

    function getDeveloperUrl()
    {
        return 'http://www.itmundi.nl';
    }

    function hasCpSection()
    {
        return true;
    }
    
}