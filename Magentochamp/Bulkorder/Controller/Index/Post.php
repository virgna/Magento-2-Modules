<?php

namespace Magentochamp\Bulkorder\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magentochamp\Bulkorder\Model\BulkorderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;


class Post extends \Magento\Framework\App\Action\Action
{
    protected $datetime;
    protected $_modelBulkorderFactory;

    /**
     * @param Context $context
     * @param BulkorderFactory $modelBulkorderFactory
     */
    public function __construct(
        Context $context,
        BulkorderFactory $modelBulkorderFactory,        
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->_modelBulkorderFactory = $modelBulkorderFactory;
        $this->datetime = $datetime;
        parent::__construct($context);
    }

    public function execute()
    {
        $model = $this->_modelBulkorderFactory->create();
        $data = $this->getRequest()->getPost();
        if (isset($data['id'])) {
            $model->load($data['id']);
        }
        
        $newData = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'email'=>$data['email'],'mobno'=>$data['mobno'],'pincode'=>$data['pincode'],'city'=>$data['city'],'category'=>$data['category'],'approx_qty'=>$data['approx_qty'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1);
        
        $model->setData($newData);
        try{
            $model->save();
            $this->messageManager->addSuccessMessage('Bulkorder has been submitted successfully');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_redirect('bulkorder');
        return;
    }
}