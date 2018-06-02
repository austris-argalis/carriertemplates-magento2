<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Integration;

use Magento\Sales\Model\Order\Email\Container\IdentityInterface;
use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;
use Magento\Sales\Model\Order\Email\SenderBuilder;
use Magento\Sales\Model\Order\Email\SenderBuilderFactory;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

class ShipmentSenderTest extends TestCase
{
    /**
     * @magentoDataFixture Magento/Sales/_files/shipment.php
     * @magentoAppArea adminhtml
     */
    public function testUsesSelectedTemplate()
    {
        $this->markTestSkipped();
        $objectManager = ObjectManager::getInstance();

        $mockSenderBuilderFactory = $this->getMockBuilder(SenderBuilderFactory::class)->disableOriginalConstructor()->getMock();
        $sharedIdentity = $objectManager->get(ShipmentIdentity::class);

        $shipmentSender = $objectManager->get(\Magento\Sales\Model\Order\Email\Sender\ShipmentSender::class, [
            'senderBuilderFactory' => $mockSenderBuilderFactory,
            'identityContainer' => $sharedIdentity
        ]);

        $shipmentCollection = $objectManager->get(
            \Magento\Sales\Model\ResourceModel\Order\Shipment\Collection::class
        );
        $shipment = $shipmentCollection->getFirstItem();
        $shipment->load($shipment->getId());

        $shipmentSender->send($shipment);

        $this->assertEquals('custom', $sharedIdentity->getTemplateId());
    }
}