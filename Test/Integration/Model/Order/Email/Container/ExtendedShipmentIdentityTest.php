<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Integration\Model\Order\Email\Container;

use Davay\CarrierTemplates\Model\Order\Email\Container\ExtendedShipmentIdentity;
use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractIntegrity as TestCase;

class ExtendedShipmentIdentityTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * @magentoAppArea adminhtml
     */
    public function testCustomIdentityRegistered()
    {
        $diConfig = $this->objectManager->get(\Magento\Framework\ObjectManager\ConfigInterface::class);

        $identity = $diConfig->getPreference(ShipmentIdentity::class);
        $this->assertEquals(ExtendedShipmentIdentity::class, $identity);
    }

    public function testReturnsCustomIdWhenOneConfigured()
    {
        $mockConfig = $this->getMockBuilder(\Davay\CarrierTemplates\Model\MethodTemplateConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $shipmentIdentity = $this->objectManager->create(ExtendedShipmentIdentity::class, [
            'templateConfig' => $mockConfig
        ]);

        $id = 'some_id';
        $mockConfig->method('getTemplateId')->willReturn($id);
        $shipmentIdentity->setShippingMethod('any');

        $this->assertEquals($id, $shipmentIdentity->getTemplateId());
    }

    public function testUsesDefaultWhenCustomNotSet()
    {
        $mockConfig = $this->getMockBuilder(\Davay\CarrierTemplates\Model\MethodTemplateConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @var ExtendedShipmentIdentity $shipmentIdentity */
        $shipmentIdentity = $this->objectManager->create(ExtendedShipmentIdentity::class, [
            'templateConfig' => $mockConfig
        ]);

        $mockConfig->method('getTemplateId')->willReturn(null);
        $shipmentIdentity->setShippingMethod('any');

        $this->assertEquals('sales_email_shipment_template', $shipmentIdentity->getTemplateId());
    }
}