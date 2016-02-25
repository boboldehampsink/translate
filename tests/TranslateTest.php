<?php

namespace Craft;

/**
 * Translate Test.
 *
 * Unit tests for translate.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@nerds.company>
 * @copyright Copyright (c) 2016, Bob Olde Hampsink
 * @license   MIT
 *
 * @link      http://github.com/boboldehampsink
 */
class TranslateTest extends BaseTest
{
    /**
     * Set up test.
     */
    public function setUp()
    {
        // Load plugins
        $pluginsService = craft()->getComponent('plugins');
        $pluginsService->loadPlugins();

        // Set template path
        craft()->path->setTemplatesPath(craft()->path->getCpTemplatesPath());
    }

    /**
     * Test getting of translations.
     */
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
