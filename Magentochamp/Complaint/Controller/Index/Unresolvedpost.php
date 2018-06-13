<?php

namespace Magentochamp\Complaint\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\ObjectManagerInterface;
use Magentochamp\Complaint\Model\UnresolvedFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;


class Unresolvedpost extends \Magento\Framework\App\Action\Action
{
    protected $datetime;
    protected $_modelUnresolvedFactory;
    protected $fileSystem;
    protected $uploaderFactory;
    protected $allowedExtensions = ['png','jpeg','jpg'];
    protected $fileId = 'uploadfile1';
    protected $_objectManager;
    /**
     * @param Context $context
     * @param UnresolvedFactory $modelUnresolvedFactory
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        Context $context,
        UnresolvedFactory $modelUnresolvedFactory,        
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->_objectManager = $objectManager;
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->_modelUnresolvedFactory = $modelUnresolvedFactory;
        $this->datetime = $datetime;
        parent::__construct($context);
    }

    public function execute()
    {
        $model = $this->_modelUnresolvedFactory->create();
        $data = $this->getRequest()->getPost();
        if (isset($data['id'])) {
            $model->load($data['id']);
        }

        $destinationPath = $this->getDestinationPath();
        if(!empty($_FILES)){
            $filename =  $_FILES[$this->fileId]['name'];
        }
        $newData = array('orderid'=>$data['orderid'],'uploadfile'=>$filename,'comments'=>$data['comments'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1);
        
        $model->setData($newData);
        try{
            if(!$this->validateOrder($data['orderid'])){
                $this->messageManager->addErrorMessage('Sorry, We can\'t find your order. Please contact to ceramicka helpline number.');
                $this->_redirect('complaint');
                return;
            }
            if($filename){
                $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                    ->setAllowCreateFolders(true)
                    ->setAllowedExtensions($this->allowedExtensions)
                    ->addValidateCallback('validate', $this, 'validateFile');
                if (!$uploader->save($destinationPath)) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
            }   
            $model->save();
            
            $this->messageManager->addSuccessMessage('Complaint has been submitted successfully');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_redirect('complaint');
        return;
    }

    public function validateOrder($id){
        $orderData = $this->_objectManager->create('\Magento\Sales\Api\Data\OrderInterface')->loadByIncrementId($id);
        if(!empty($orderData->getData())){
            return true;
        }else{
            return false;
        }
    }

    public function validateFile($filePath)
    {
        // @todo
        // your custom validation code here
    }

    public function getDestinationPath()
    {
        return $this->fileSystem
            ->getDirectoryWrite(DirectoryList::TMP)
            ->getAbsolutePath('/');
    }
}