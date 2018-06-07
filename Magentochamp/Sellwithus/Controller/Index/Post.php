<?php

namespace Magentochamp\Sellwithus\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magentochamp\Sellwithus\Model\SellwithusFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;


class Post extends \Magento\Framework\App\Action\Action
{
    protected $datetime;
    protected $_modelSellwithusFactory;

    /**
     * @param Context $context
     * @param SellwithusFactory $modelSellwithusFactory
     */
    public function __construct(
        Context $context,
        SellwithusFactory $modelSellwithusFactory,        
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->_modelSellwithusFactory = $modelSellwithusFactory;
        $this->datetime = $datetime;
        parent::__construct($context);
    }

    public function execute()
    {
        $model = $this->_modelSellwithusFactory->create();
        $data = $this->getRequest()->getPost();
        if (isset($data['id'])) {
            $model->load($data['id']);
        }
        
        $newData = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'email'=>$data['email'],'mobno'=>$data['mobno'],'pincode'=>$data['pincode'],'city'=>$data['city'],'category'=>$data['category'],'approx_qty'=>$data['approx_qty'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1);
        
        $model->setData($newData);
        try{
            $model->save();
            $this->messageManager->addSuccessMessage('Sellwithus has been submitted successfully');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_redirect('sellwithus');
        return;
    }
}