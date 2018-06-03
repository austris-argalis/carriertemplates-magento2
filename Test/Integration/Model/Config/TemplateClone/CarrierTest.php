<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Integration\Model\Config\TemplateClone;

use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractIntegrity as TestCase;

class CarrierTest extends TestCase
{
    /**
     * @magentoConfigFixture current_store carriers/tablerate/active 1
     * @magentoConfigFixture current_store carriers/flatrate/active 1
     * @magentoConfigFixture current_store carriers/freeshipping/active 0
     */
    public function testReturnsListOfPrefixData()
    {
        $carrierPrefix = ObjectManager::getInstance()->create(
            \Davay\CarrierTemplates\Model\Config\TemplateClone\Carriers::class
        );

        $expected = [
            [
                'field' => 'flatrate_',
                'label' => 'Flat Rate',
            ],
            [
                'field' => 'flatrate_guest_',
                'label' => 'Flat Rate Guest',
            ],
            [
                'field' => 'tablerate_',
                'label' => 'Best Way',
            ],
            [
                'field' => 'tablerate_guest_',
                'label' => 'Best Way Guest',
            ],
        ];
        $this->assertEquals($expected, $carrierPrefix->getPrefixes());
    }
}