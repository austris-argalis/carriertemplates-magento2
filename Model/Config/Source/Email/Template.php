<?php
/**
 * @author austris
 * @copyright Copyright (c) 2018
 */

namespace Davay\CarrierTemplates\Model\Config\Source\Email;

use Magento\Email\Model\ResourceModel\Template\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\Registry;

class Template extends DataObject implements ArrayInterface
{
    /**
     * @var CollectionFactory
     */
    protected $templatesFactory;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var array
     */
    private $data;

    /**
     * @param Registry $coreRegistry
     * @param CollectionFactory $templatesFactory
     * @param array $data
     */
    public function __construct(
        Registry $coreRegistry,
        CollectionFactory $templatesFactory,
        array $data = []
    ) {
        parent::__construct($data);
        $this->coreRegistry = $coreRegistry;
        $this->templatesFactory = $templatesFactory;
        $this->data = $data;
    }

    /**
     * Generate list of email templates
     *
     * @return array
     */
    public function toOptionArray()
    {
        /** @var $collection \Magento\Email\Model\ResourceModel\Template\Collection */
        if (!($collection = $this->coreRegistry->registry('config_system_email_template'))) {
            $collection = $this->templatesFactory->create();
            $collection->load();
            $this->coreRegistry->register('config_system_email_template', $collection);
        }
        $options = $collection->toOptionArray();
        $empty = ['---- Email Template ----'];

        return array_merge($empty, $options);
    }
}
