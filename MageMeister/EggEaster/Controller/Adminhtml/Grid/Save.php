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
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Variable\Model\VariableFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \MageMeister\Grid\Model\eggeasterFactory
     */
    var $eggeasterFactory;
    protected $datetime;
    protected $fileSystem;
    protected $uploaderFactory;
    protected $allowedExtensions = ['png','jpeg','jpg'];
    protected $fileId = 'uploadfile';
    protected $varFActory;
    protected $helperData;
    public $_storeManager;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \MageMeister\EggEaster\Model\EggEasterFactory $eggeasterFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        VariableFactory $varFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \MageMeister\EggEaster\Helper\Data $helperData,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MageMeister\EggEaster\Model\EggEasterFactory $eggeasterFactory
    ) {
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->varFActory = $varFactory;
        $this->datetime = $datetime;
        $this->helperData = $helperData;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
        $this->eggeasterFactory = $eggeasterFactory;
    }
 
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $imagePath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('eggeaster/grid/addrow');
            return;
        }
        try {
            
            $destinationPath = $this->getDestinationPath();
            $filename = '';
            if(!empty($_FILES)){
                $filename =  $_FILES[$this->fileId]['name'];
            }
            $data['uploadfile'] = $filename;
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

            $rowData = $this->eggeasterFactory->create();
            $lastInsertId = $this->helperData->getLastIncrementId() + 1;
            
            if (isset($data['id'])) {
                $data['updated_at'] = $this->datetime->gmtDate();
                $rowData->setId($data['id']);
                $rowData->save();
                $getVarId = $rowData->load($data['id'])->getVariableId();
                
                $variable = $this->varFActory->create();
                $loadByCode = $variable->load($getVarId);
                $loadByCode->setName($data['eggname']);
                $loadByCode->save();
                $rowData->setData($data);
                $rowData->save();
            }else{
                $data['short_code'] = '{{customVar code='.$data['eggcode'].'}}';
                $data['created_at'] = $this->datetime->gmtDate();
                $variable = $this->varFActory->create();
                $loadByCode = $variable->loadByCode($data['eggcode']);
                $eggImage = $imagePath.$filename;
                $dataVar = [
                    'code' => $data['eggcode'],
                    'name' => $data['eggname'],
                    'html_value' => '<span id="eeh_egg_'.$lastInsertId.'" class="eeh_egg"><img src="'.$eggImage.'"></span>',
                    'plain_value' => '',

                ];
                $variable->setData($dataVar);
                $variable->save();
                $data['variable_id'] = $variable->getId();
                
                $rowData->setData($data);
                $rowData->save();
            }
            
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('eggeaster/grid/index');
    }
 
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MageMeister_EggEaster::save');
    }

    public function getDestinationPath()
    {
        return $this->fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('/');
    }
}