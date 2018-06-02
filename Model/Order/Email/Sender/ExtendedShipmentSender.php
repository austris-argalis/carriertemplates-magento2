<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Model\Order\Email\Sender;

use Davay\CarrierTemplates\Model\Order\Email\Container\ExtendedShipmentIdentity;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;

class ExtendedShipmentSender extends ShipmentSender
{
    /**
     * @var ExtendedShipmentIdentity
     */
    protected $identityContainer;

    /**
     * @param Order $order
     * @return bool
     */
    protected function checkAndSend(Order $order)
    {
        $shippingMethod = $order->getShippingMethod(true);
        $this->identityContainer->setShippingMethod($shippingMethod->getData('carrier_code'));

        parent::checkAndSend($order);
    }
}