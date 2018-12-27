<?php
/**
 * MageMeister Inc.
 *
 * NOTICE OF LICENSE
 *
 * <!--LICENSETEXT-->
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://magemeister.com for more information.
 *
 * @category    MageMeister
 * @package     MageMeister_EggEaster
 * @copyright   Copyright (c) 2013-2018 MageMeister Inc. (http://magemeister.com)
 * @author      Virang Jethva <virang.jethva@magemeister.com>
 * @info        MageMeister Inc. <hello@magemeister.com>
 */

namespace MageMeister\EggEaster\Controller\Adminhtml\Grid;
 
use Magento\Framework\Controller\ResultFactory;
 
class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
 
    /**
     * @var \MageMeister\Grid\Model\GridFactory
     */
    private $eggeasterFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \MageMeister\EggEaster\Model\EggEasterFactory $eggeaster
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \MageMeister\EggEaster\Model\EggEasterFactory $eggeasterFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->eggeasterFactory = $eggeasterFactory;
    }
 
    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->eggeasterFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
          
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('eggeaster/grid/rowdata');
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
        return $this->_authorization->isAllowed('MageMeister_EggEaster::add_row');
    }
}