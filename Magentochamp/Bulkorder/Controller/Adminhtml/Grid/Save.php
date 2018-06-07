<?php
 
/**
 * Grid Admin Cagegory Map Record Save Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Bulkorder
 * @author    Magentochamp
 */
namespace Magentochamp\Bulkorder\Controller\Adminhtml\Grid;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magentochamp\Grid\Model\bulkorderFactory
     */
    var $bulkorderFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magentochamp\Bulkorder\Model\GridFactory $bulkorderFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magentochamp\Bulkorder\Model\BulkorderFactory $bulkorderFactory
    ) {
        parent::__construct($context);
        $this->bulkorderFactory = $bulkorderFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('bulkorder/grid/addrow');
            return;
        }
        try {
            $rowData = $this->bulkorderFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('bulkorder/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magentochamp_Bulkorder::save');
    }
}