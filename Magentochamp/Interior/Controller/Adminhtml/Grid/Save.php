<?php
 
/**
 * Grid Admin Cagegory Map Record Save Controller.
 * @category  Magentochamp
 * @package   Magentochamp_Interior
 * @author    Magentochamp
 */
namespace Magentochamp\Interior\Controller\Adminhtml\Grid;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magentochamp\Grid\Model\interiorFactory
     */
    var $interiorFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magentochamp\Interior\Model\InteriorFactory $interiorFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magentochamp\Interior\Model\InteriorFactory $interiorFactory
    ) {
        parent::__construct($context);
        $this->interiorFactory = $interiorFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('interior/grid/addrow');
            return;
        }
        try {
            $rowData = $this->interiorFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('interior/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magentochamp_Interior::save');
    }
}