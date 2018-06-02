<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class MethodTemplateConfig
{
    const CONFIG_CUSTOM_TEMPLATE_PATH = 'sales_email/shipment_templates/%s_template';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $methodName
     * @return string|null
     */
    public function getTemplateId($methodName)
    {
        return $this->readConfigValue($methodName);
    }

    /**
     * @param $methodName
     * @return string|null
     */
    public function getGuestTemplateId($methodName)
    {
        return $this->readConfigValue($methodName . '_guest');
    }

    /**
     * @param $methodName
     * @return string|null
     */
    private function readConfigValue($methodName)
    {
        return $this->scopeConfig->getValue(sprintf(self::CONFIG_CUSTOM_TEMPLATE_PATH, $methodName));
    }
}