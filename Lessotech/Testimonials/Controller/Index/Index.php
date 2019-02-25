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

namespace Lessotech\Testimonials\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    /**
     * @var Magento\Framework\UrlInterface;
     */
    protected $urlInterface;
    
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        UrlInterface $urlInterface
    ) {
        $this->session = $customerSession;
        $this->urlInterface = $urlInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {
            $this->messageManager->addSuccessMessage('Testimonials submitted successfully !');
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/lessotechtestimonials/index/testimonials');
            return $resultRedirect;
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
