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
 *
 * @coversDefaultClass Craft\TranslateService
 * @covers ::<!public>
 */
class TranslateServiceTest extends BaseTest
{
    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass()
    {
        // Set up parent
        parent::setUpBeforeClass();

        // Require dependencies
        require_once __DIR__.'/../services/TranslateService.php';

        // Create test translation file
        $file = __DIR__.'/../translations/test.php';
        IOHelper::writeToFile($file, '<?php return array (\'test\' => \'test\');');
    }

    /**
     * {@inheritdoc}
     */
    public static function tearDownAfterClass()
    {
        // Remove test file
        $file = __DIR__.'/../translations/test.php';
        IOHelper::deleteFile($file);

        // Tear down parent
        parent::tearDownAfterClass();
    }

    /**
     * Test set.
     *
     * @covers ::set
     */
    public function testSet()
    {
        $file = __DIR__.'/../translations/test.php';
        IOHelper::changePermissions($file, 0666);

        $service = new TranslateService();
        $service->set('test', array());

        $result = IOHelper::fileExists($file);
        $this->assertTrue((bool) $result);
    }

    /**
     * Test set with failure.
     *
     * @expectedException Craft\Exception
     *
     * @covers ::set
     */
    public function testSetWithFailure()
    {
        // Lock it for writing
        $file = __DIR__.'/../translations/test.php';
        IOHelper::changePermissions($file, 0444);

        $service = new TranslateService();
        $service->set('test', array());
    }
}
