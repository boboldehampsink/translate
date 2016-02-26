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
        require_once __DIR__.'/../elementtypes/TranslateElementType.php';
        require_once __DIR__.'/../models/TranslateModel.php';

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
    final public function testSet()
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
    final public function testSetWithFailure()
    {
        // Lock it for writing
        $file = __DIR__.'/../translations/test.php';
        IOHelper::changePermissions($file, 0444);

        $service = new TranslateService();
        $service->set('test', array());
    }

    /**
     * Test get.
     *
     * @param array $criteriaAttributes
     * @param int   $expectedCount
     *
     * @covers ::get
     * @dataProvider provideCriteriaAttributes
     */
    final public function testGet(array $criteriaAttributes, $expectedCount)
    {
        $this->setMockTemplatesService();

        // Set up translate criteria
        $criteria = new ElementCriteriaModel($criteriaAttributes, new TranslateElementType());

        $service = new TranslateService();
        $service->init();
        $results = $service->get($criteria);

        $this->assertCount($expectedCount, $results);
    }

    /**
     * Provide criteria attributes.
     *
     * @return array
     */
    final public function provideCriteriaAttributes()
    {
        return array(
            'With directory source' => array(array(
                'source' => __DIR__.'/../',
                'status' => null,
            ), 17),
            'With file source' => array(array(
                'source' => __DIR__.'/../translations/test.php',
                'status' => null,
            ), 0),
            'With search' => array(array(
                'source' => __DIR__.'/../',
                'search' => 'test',
            ), 0),
            'With status' => array(array(
                'source' => __DIR__.'/../',
            ), 0),
        );
    }

    /**
     * Mock TemplatesService.
     */
    private function setMockTemplatesService()
    {
        $mock = $this->getMockBuilder('Craft\TemplatesService')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $mock->expects($this->any())->method('render')->willReturn('string');

        $this->setComponent(craft(), 'templates', $mock);
    }
}
