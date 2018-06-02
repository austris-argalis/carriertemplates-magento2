<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Model\Config\TemplateClone;

use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Config;

class Carriers
{
    /**
     * @var Config
     */
    private $shippingConfig;

    /**
     * @param Config $shippingConfig
     */
    public function __construct(Config $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    /**
     * @return array
     */
    public function getPrefixes()
    {
        $carriers = $this->shippingConfig->getActiveCarriers();
        $prefixes = [];

        foreach ($carriers as $carrier) {
            /* @var AbstractCarrier $carrier */
            $prefixes[] = [
                'field' => $carrier->getCarrierCode() . '_',
                'label' => $carrier->getConfigData('title'),
            ];
            $prefixes[] = [
                'field' => $carrier->getCarrierCode() . '_guest_',
                'label' => $carrier->getConfigData('title') . ' ' . __('Guest'),
            ];
        }

        return $prefixes;
    }

}