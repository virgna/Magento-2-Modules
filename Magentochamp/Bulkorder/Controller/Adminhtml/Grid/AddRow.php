<?php
/**
 * Magentochamp Bulkorder Grid List Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Bulkorder
 * @author    Magentochamp
 */
namespace Magentochamp\Bulkorder\Controller\Adminhtml\Grid;
 
use Magento\Framework\Controller\ResultFactory;
 
class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
 
    /**
     * @var \Magentochamp\Bulkorder\Model\GridFactory
     */
    private $bulkorderFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magentochamp\Bulkorder\Model\BulkorderFactory $bulkorder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magentochamp\Bulkorder\Model\BulkorderFactory $bulkorderFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->bulkorderFactory = $bulkorderFactory;
    }
 
    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->bulkorderFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
          
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('bulkorder/grid/rowdata');
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
        return $this->_authorization->isAllowed('Magentochamp_Bulkorder::add_row');
    }
}