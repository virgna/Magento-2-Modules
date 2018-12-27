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

namespace MageMeister\EggEaster\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use MageMeister\EggEaster\Model\EggEasterFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;


class Post extends \Magento\Framework\App\Action\Action
{
    protected $datetime;
    protected $_modelEggEasterFactory;

    /**
     * @param Context $context
     * @param EggEasterFactory $modelEggEasterFactory
     */
    public function __construct(
        Context $context,
        EggEasterFactory $modelEggEasterFactory,        
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime
    ) {
        $this->_modelEggEasterFactory = $modelEggEasterFactory;
        $this->datetime = $datetime;
        parent::__construct($context);
    }

    public function execute()
    {
        $model = $this->_modelEggEasterFactory->create();
        $data = $this->getRequest()->getPost();
        if (isset($data['id'])) {
            $model->load($data['id']);
        }
        
        $newData = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'firmname'=>$data['firmname'],'email'=>$data['email'],'mobno'=>$data['mobno'],'pincode'=>$data['pincode'],'city'=>$data['city'],'speciality'=>$data['speciality'],'experience'=>$data['experience'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1);
        
        $model->setData($newData);
        try{
            $model->save();
            $this->messageManager->addSuccessMessage('EggEaster has been submitted successfully');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->_redirect('eggeaster');
        return;
    }
}