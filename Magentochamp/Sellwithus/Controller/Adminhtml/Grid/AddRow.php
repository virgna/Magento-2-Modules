<?php
/**
 * Magentochamp Sellwithus Grid List Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Sellwithus
 * @author    Magentochamp
 */
namespace Magentochamp\Sellwithus\Controller\Adminhtml\Grid;
 
use Magento\Framework\Controller\ResultFactory;
 
class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
 
    /**
     * @var \Magentochamp\Sellwithus\Model\GridFactory
     */
    private $sellwithusFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magentochamp\Sellwithus\Model\SellwithusFactory $sellwithus
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magentochamp\Sellwithus\Model\SellwithusFactory $sellwithusFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->sellwithusFactory = $sellwithusFactory;
    }
 
    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->sellwithusFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
          
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('sellwithus/grid/rowdata');
               return;
           }
       }
 
       $this->coreRegistry->register('row_data', $rowData);
       $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       $title = $rowId ? __('Edit Row Data ').$rowTitle : __('Add Row Data');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }
 
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magentochamp_Sellwithus::add_row');
    }
}