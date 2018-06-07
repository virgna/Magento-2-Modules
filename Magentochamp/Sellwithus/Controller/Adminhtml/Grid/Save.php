<?php
 
/**
 * Grid Admin Cagegory Map Record Save Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Sellwithus
 * @author    Magentochamp
 */
namespace Magentochamp\Sellwithus\Controller\Adminhtml\Grid;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magentochamp\Grid\Model\sellwithusFactory
     */
    var $sellwithusFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magentochamp\Sellwithus\Model\GridFactory $sellwithusFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magentochamp\Sellwithus\Model\SellwithusFactory $sellwithusFactory
    ) {
        parent::__construct($context);
        $this->sellwithusFactory = $sellwithusFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('sellwithus/grid/addrow');
            return;
        }
        try {
            $rowData = $this->sellwithusFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('sellwithus/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magentochamp_Sellwithus::save');
    }
}