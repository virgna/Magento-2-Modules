<?php

namespace Entrepids\ProductImporter\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action
{

    protected $_objectManager;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_objectManager = $objectManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_objectManager->create('Entrepids\ProductImporter\Helper\Data')->readTable();
    }
}