<?php
namespace Craft;

class TranslateTest extends BaseTest
{

    public function setUp()
    {

        // Load plugins
        $pluginsService = craft()->getComponent('plugins');
        $pluginsService->loadPlugins();

        // Set template path
        craft()->path->setTemplatesPath(craft()->path->getCpTemplatesPath());
    }

    public function testGet()
    {

        // Set up criteria, get plugin translations
        $criteria = craft()->elements->getCriteria('Translate');
        $criteria->status = null;
        $criteria->locale = 'en_us';
        $criteria->source = craft()->path->getPluginsPath();

        // Get translations, always finding some because they're at least in this plugin
        $translations = craft()->translate->get($criteria);

        // The count should thus be positive
        $this->assertTrue((bool) count($translations));
    }
}
