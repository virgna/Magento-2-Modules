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

namespace MageMeister\EggEaster\Block;

use Magento\Store\Model\ScopeInterface;

class EggEaster extends \Magento\Framework\View\Element\Template
{

    const XML_PATH_MAGEMEISTER = 'eggeaster/';

    protected $_helper;

    protected $_varFactory;
    
    protected $_eggFactory;

    public $_storeManager;

    protected $scopeConfig;

    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        \MageMeister\EggEaster\Helper\Data $helper,
        \Magento\Variable\Model\ResourceModel\Variable\CollectionFactory $varFactory,
        \MageMeister\EggEaster\Model\ResourceModel\EggEaster\CollectionFactory $eggFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    	)
    {
        $this->_helper = $helper;
        $this->_varFactory = $varFactory;
        $this->_eggFactory = $eggFactory;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
        //parent::__construct($context);
    }

    /*public function variableCollection(){
        $var = $this->_varFactory->create();
        //$var->loadByCode('mcegg1');
        return $var->getCollection();
        // return "variale";
    }*/

    public function variableCollection(){
        $var = $this->_eggFactory->create()->addFieldToFilter('status',1);
        $varCollection = $var->join(array('t2' => 'variable'),'main_table.variable_id = t2.variable_id','t2.variable_id');
        return $varCollection;
    }

    public function eggsImages(){
        $imageArray = array();$i=0;
        foreach($this->variableCollection() as $value){
            $imageArray[] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).$value->getUploadfile();
            $i++;
        }
        return json_encode($imageArray);
    }

    public function totalEggs(){
        $varCollectionFactory = $this->_eggFactory->create()->addFieldToFilter('status',1);
        $getSize = $varCollectionFactory->getSize();
        return $getSize;
    }

    public function getbaseUrl(){
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_MAGEMEISTER .'general/'. $code, $storeId);
    }
}