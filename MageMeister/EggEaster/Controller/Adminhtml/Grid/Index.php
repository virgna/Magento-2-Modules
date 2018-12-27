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

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Mapped eBay Order List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageMeister_EggEaster::grid_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Grid List'));
        return $resultPage;
    }

    /**
     * Check Order Import Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageMeister_EggEaster::grid_list');
    }
}
