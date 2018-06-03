<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Integration\Model\Order\Email\Sender;

use Davay\CarrierTemplates\Model\Order\Email\Sender\ExtendedShipmentSender;
use Magento\Framework\ObjectManager\ConfigInterface;
use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;
use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;
use Magento\Sales\Model\Order\Email\SenderBuilderFactory;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractIntegrity as TestCase;

class ShipmentSenderTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var ConfigInterface
     */
    private $diConfig;

    /**
     * @magentoAppArea adminhtml
     */
    public function testConfiguredForCustomSender()
    {
        $arguments = $this->diConfig->getArguments('SalesOrderShipmentSendEmails');
        $this->assertEquals(ExtendedShipmentSender::class, $arguments['emailSender']['instance']);
        $this->assertEquals(ExtendedShipmentSender::class, $this->diConfig->getPreference(ShipmentSender::class));
    }

    /**
     * @magentoAppArea adminhtml
     * @magentoDataFixture Magento/Sales/_files/shipment.php
     * @magentoConfigFixture default/sales_email/shipment_templates/flatrate_template template_name
     */
    public function testUsesSelectedTemplate()
    {
        $objectManager = ObjectManager::getInstance();

        $mockSenderBuilderFactory = $this->getMockBuilder(SenderBuilderFactory::class)
            ->disableOriginalConstructor()->getMock();
        $sharedIdentity = $objectManager->get(ShipmentIdentity::class);

        $shipmentSender = $objectManager->get(
            ShipmentSender::class,
            [
                'senderBuilderFactory' => $mockSenderBuilderFactory,
                'identityContainer' => $sharedIdentity
            ]
        );

        $shipmentCollection = $objectManager->get(
            \Magento\Sales\Model\ResourceModel\Order\Shipment\Collection::class
        );
        $shipment = $shipmentCollection->getFirstItem();
        $shipment->load($shipment->getId());
        $order = $shipment->getOrder();
        $order->setShippingMethod('flatrate_flatrate')->save();
        $shipmentSender->send($shipment);

        $this->assertEquals('template_name', $sharedIdentity->getTemplateId());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = ObjectManager::getInstance();
        $this->diConfig = $this->objectManager->get(ConfigInterface::class);
    }
}