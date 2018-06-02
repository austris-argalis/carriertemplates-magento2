<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Unit\Model\Order\Email\Container;

use Davay\CarrierTemplates\Model\Order\Email\Container\ExtendedShipmentIdentity;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class ExtendedShipmentIdentityTest extends TestCase
{

    private $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);
    }

    public function testAcceptsShippingMethod()
    {
        $subject = $this->objectManager->getObject(ExtendedShipmentIdentity::class);

        $methodName = 'custom_shipping_method';
        $subject->setShippingMethod($methodName);

        $this->assertEquals($methodName, $subject->getShippingMethod());
    }
}

