<?php
/**
 * Magentochamp Complaint Grid List Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Complaint
 * @author    Magentochamp
 */
namespace Magentochamp\Complaint\Controller\Adminhtml\Grid;
 
use Magento\Framework\Controller\ResultFactory;
 
class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
 
    /**
     * @var \Magentochamp\Complaint\Model\GridFactory
     */
    private $complaintFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magentochamp\Complaint\Model\ComplaintFactory $complaint
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magentochamp\Complaint\Model\ComplaintFactory $complaintFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->complaintFactory = $complaintFactory;
    }
 
    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->complaintFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
          
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('complaint/grid/rowdata');
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
        return $this->_authorization->isAllowed('Magentochamp_Complaint::add_row');
    }
}