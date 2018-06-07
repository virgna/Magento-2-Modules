<?php
namespace Magentochamp\Interior\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;
    protected $urlInterface;
    
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
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

        /*if (!$this->session->isLoggedIn()) {
            //$url = $this->_redirect->getRefererUrl();
            $url = $this->urlInterface->getCurrentUrl();

        // Or get any custom url
        //$url = $this->urlInterface->getUrl('my/custom/url');

        // Create login URL
        $login_url = $this->urlInterface
                          ->getUrl('customer/account/login', 
                                array('referer' => base64_encode($url))
                            );

        // Redirect to login URL
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($login_url);
        return $resultRedirect;
        }*/

        // 1. POST request : Get booking data
        $post = (array) $this->getRequest()->getPost();

        if (!empty($post)) {
            // Doing-something with...
            // Display the succes form validation message
            $this->messageManager->addSuccessMessage('Interior submitted successfully !');

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/magentochampinterior/index/interior');

            return $resultRedirect;
        }
        // 2. GET request : Render the booking page 
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}