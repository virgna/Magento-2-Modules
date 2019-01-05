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

    /**
     * Get Config Path
     *
     * @var string
     */
    const XML_PATH_MAGEMEISTER = 'eggeaster/';

    /**
     * MageMeister Helper
     *
     * @var \MageMeister\EggEaster\Helper\Data
     */
    protected $_helper;

    /**
     * MageMeister Collection Factory
     *
     * @var \Magento\Variable\Model\ResourceModel\Variable\CollectionFactory
     */
    protected $_varFactory;
    
    /**
     * MageMeister Collection Factory
     *
     * @var \Magento\Variable\Model\ResourceModel\Variable\CollectionFactory
     */
    protected $_eggFactory;

    /**
     * MageMeister Store Manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $_storeManager;

    /**
     * MageMeister Scope Config Interface
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /** 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \MageMeister\EggEaster\Helper\Data $helper
     * @param \Magento\Variable\Model\ResourceModel\Variable\CollectionFactory $varFactory
     * @param \MageMeister\EggEaster\Model\ResourceModel\EggEaster\CollectionFactory $eggFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
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
    }

    /**
     * @return \Magento\Variable\Model\ResourceModel\Variable\Collection
     */
    public function variableCollection(){
        $var = $this->_eggFactory->create()->addFieldToFilter('status',1);
        $varCollection = $var->join(array('t2' => 'variable'),'main_table.variable_id = t2.variable_id','t2.variable_id');
        return $varCollection;
    }

    /**
     * Return eggs images array in json format
     * 
     * @return array
     */
    public function eggsImages(){
        $imageArray = array();$i=0;
        foreach($this->variableCollection() as $value){
            $imageArray[] = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).$value->getUploadfile();
            $i++;
        }
        return json_encode($imageArray);
    }

    /**
     * Get total eggs count
     * 
     * @return int
     */
    public function totalEggs(){
        $varCollectionFactory = $this->_eggFactory->create()->addFieldToFilter('status',1);
        $getSize = $varCollectionFactory->getSize();
        return $getSize;
    }

    /**
     * Get Base Url
     * 
     * @return string
     */
    public function getbaseUrl(){
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * Get Config Value
     * 
     * @return string
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * Get Config Value
     * 
     * @return string
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_MAGEMEISTER .'general/'. $code, $storeId);
    }
}