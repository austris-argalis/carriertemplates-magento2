<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Model\Order\Email\Container;

use Davay\CarrierTemplates\Model\MethodTemplateConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Model\Order\Email\Container\ShipmentIdentity;
use Magento\Store\Model\StoreManagerInterface;

class ExtendedShipmentIdentity extends ShipmentIdentity
{
    private $shippingMethod;

    /**
     * @var MethodTemplateConfig
     */
    private $templateConfig;

    public function __construct(ScopeConfigInterface $scopeConfig, StoreManagerInterface $storeManager, MethodTemplateConfig $templateConfig)
    {
        parent::__construct($scopeConfig, $storeManager);

        $this->templateConfig = $templateConfig;
    }

    /**
     * @return string
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param string $name
     */
    public function setShippingMethod($name)
    {
        $this->shippingMethod = $name;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        if ($this->shippingMethod !== null) {
            $templateId = $this->templateConfig->getTemplateId($this->shippingMethod);
        }

        return $templateId ?? parent::getTemplateId();
    }

    /**
     * @return string
     */
    public function getGuestTemplateId()
    {
        if ($this->shippingMethod !== null) {
            $templateId = $this->templateConfig->getGuestTemplateId($this->shippingMethod);
        }

        return $templateId ?? parent::getGuestTemplateId();
    }
}