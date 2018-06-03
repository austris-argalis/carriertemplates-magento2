<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Test\Integration\Model;

use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractIntegrity as TestCase;

class MethodTemplateConfigTest extends TestCase
{
    /**
     * @magentoConfigFixture default/sales_email/shipment_templates/mymethod_template template_name
     */
    public function testReadsCorrectScopeConfigValue()
    {
        \Davay\CarrierTemplates\Model\MethodTemplateConfig::CONFIG_CUSTOM_TEMPLATE_PATH;
        $subject = ObjectManager::getInstance()->create(\Davay\CarrierTemplates\Model\MethodTemplateConfig::class);

        $this->assertEquals('template_name', $subject->getTemplateId('mymethod'));
    }

    /**
     * @magentoConfigFixture default/sales_email/shipment_templates/mymethod_guest_template guest_template_name
     */
    public function testReadsCorrectGuestScopeConfigValue()
    {
        \Davay\CarrierTemplates\Model\MethodTemplateConfig::CONFIG_CUSTOM_TEMPLATE_PATH;
        $subject = ObjectManager::getInstance()->create(\Davay\CarrierTemplates\Model\MethodTemplateConfig::class);

        $this->assertEquals('guest_template_name', $subject->getGuestTemplateId('mymethod'));
    }
}