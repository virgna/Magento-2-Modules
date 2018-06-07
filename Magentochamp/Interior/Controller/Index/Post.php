<?php

namespace Magentochamp\Interior\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magentochamp\Interior\Model\InteriorFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;


class Post extends \Magento\Framework\App\Action\Action
{
    protected $datetime;
    protected $_modelInteriorFactory;

    /**
     * @param Context $context
     * @param InteriorFactory $modelInteriorFactory
     */
    public function __construct(
        Context $context,
        InteriorFactory $modelInteriorFactory,        
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->_modelInteriorFactory = $modelInteriorFactory;
        $this->datetime = $datetime;
        parent::__construct($context);
    }

    public function execute()
    {
        $model = $this->_modelInteriorFactory->create();
        $data = $this->getRequest()->getPost();
        if (isset($data['id'])) {
            $model->load($data['id']);
        }
        
        $newData = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'firmname'=>$data['firmname'],'email'=>$data['email'],'mobno'=>$data['mobno'],'pincode'=>$data['pincode'],'city'=>$data['city'],'speciality'=>$data['speciality'],'experience'=>$data['experience'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1);
        
        $model->setData($newData);
        try{
            $model->save();
            $this->messageManager->addSuccessMessage('Interior has been submitted successfully');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_redirect('interior');
        return;
    }
}