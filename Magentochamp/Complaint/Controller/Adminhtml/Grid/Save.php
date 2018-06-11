<?php
 
/**
 * Grid Admin Cagegory Map Record Save Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Complaint
 * @author    Magentochamp
 */
namespace Magentochamp\Complaint\Controller\Adminhtml\Grid;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magentochamp\Grid\Model\complaintFactory
     */
    var $complaintFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magentochamp\Complaint\Model\GridFactory $complaintFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magentochamp\Complaint\Model\ComplaintFactory $complaintFactory
    ) {
        parent::__construct($context);
        $this->complaintFactory = $complaintFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('complaint/grid/addrow');
            return;
        }
        try {
            $rowData = $this->complaintFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('complaint/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magentochamp_Complaint::save');
    }
}