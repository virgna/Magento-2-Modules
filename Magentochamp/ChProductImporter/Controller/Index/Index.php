<?php
namespace Magentochamp\ChProductImporter\Controller\Index;
use Magento\Store\Model\ScopeInterface;
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
        parent::__construct($context);
        
        $this->_objectManager = $objectManager;
    }

    public function execute()
    {
        $this->_objectManager->create('Magentochamp\ChProductImporter\Helper\Data')->executeProcess();
    }
}