<?php
/**
 * Lessotech
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the lessotech.com license that is
 * available through the world-wide-web at this URL:
 * https://www.lessotech.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Lessotech
 * @package     Lessotech_Testimonials
 * @copyright   Copyright (c) Lessotech (http://www.lessotech.com/)
 * @license     http://www.lessotech.com/LICENSE.txt
 */

namespace Lessotech\Testimonials\Controller\Adminhtml\Grid;
 
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Lessotech\Grid\Model\testimonialsFactory
     */
    var $testimonialsFactory;
 
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Lessotech\Testimonials\Model\GridFactory $testimonialsFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Lessotech\Testimonials\Model\TestimonialsFactory $testimonialsFactory
    ) {
        parent::__construct($context);
        $this->testimonialsFactory = $testimonialsFactory;
    }
 
    /**
     * Save Testimonial Data
     *
     * @return Array
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        if (!$data) {
            $this->_redirect('testimonials/grid/addrow');
            return;
        }
        try {
            $rowData = $this->testimonialsFactory->create();
            if (isset($data['id'])) {
                $rowData->setStatus($data['status']);
                $rowData->setId($data['id']);
                $rowData->save();
                $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('testimonials/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lessotech_Testimonials::save');
    }
}
