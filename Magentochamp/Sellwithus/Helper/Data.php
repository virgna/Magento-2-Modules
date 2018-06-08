<?php

namespace Magentochamp\Sellwithus\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	protected $_categoryCollectionFactory;
    
    protected $_categoryHelper;
    
    public function __construct(
    	\Magento\Framework\App\Helper\Context $context,
    	\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        array $data = []
    	)
    {
    	$this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
        //parent::__construct($context);
    }

    public function getCategoryCollectionData()
    {
        $collection = $this->_categoryCollectionFactory->create()
            ->addAttributeToSelect(array('id','name'))
            ->addAttributeToFilter('level', '3')
            ->addAttributeToFilter('is_active','1');
        return $collection;
    }

    public function getCategoryCollectionArr()
    {
    	$options = array();
        foreach($this->getCategoryCollectionData() as $data){
        	    $options[] = array(
                   'label' => $data->getName(),
                   'value' => $data->getId()
                );
        	
        }
        return $options;
    }

    public function toOptionCtypeData()
    {
        return 
            ['1' => __('Individual'),'2' => __('Sole Proprietorship Concern'),'3' => __('Partnership Firm – registered / unregistered'),'4' => __('One Person Company'),'5' => __('Private Company'),'6' => __('Public Limited Company – Unlisted &amp; Listed'),'7' => __('Limited Liability Partnership'),'8' => __('Hindu Undivided Family (HUF)'),'9' => __('Foreign Company'),'10' => __('Trust')];
    }

    public function toOptionCtypeArray()
    {
        $result = [];
        foreach ($this->toOptionCtypeData() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }

    public function toOptionStateData()
    {
        return ['AN' => __('Andaman and Nicobar Islands'),'AP' => __('Andhra Pradesh'),'AR' => __('Arunachal Pradesh'),'AS' => __('Assam'),'BR' => __('Bihar'),'CH' => __('Chandigarh'),'CT' => __('Chhattisgarh'),'DD' => __('Daman and Diu'),'DL' => __('Delhi'),'DN' => __('Dadra And Nagar Haveli'),'GA' => __('Goa'),'GJ' => __('Gujarat'),'HP' => __('Himachal Pradesh'),'HR' => __('Haryana'),'JH' => __('Jharkhand'),'JK' => __('Jammu &amp; Kashmir'),'KA' => __('Karnataka'),'KL' => __('Kerala'),'LD' => __('Lakshadweep'),'MH' => __('Maharashtra'),'ML' => __('Meghalaya'),'MN' => __('Manipur'),'MP' => __('Madhya Pradesh'),'MZ' => __('Mizoram'),'NL' => __('Nagaland'),'OD' => __('Odisha'),'OTHER' => __('Other'),'PB' => __('Punjab'),'PY' => __('Puducherry | Pondicherry'),'RJ' => __('Rajasthan'),'SK' => __('Sikkim'),'TN' => __('Tamil Nadu'),'TR' => __('Tripura'),'TS' => __('Telangana'),'UP' => __('Uttar Pradesh'),'UT' => __('Uttarakhand'),'WB' => __('West Bengal')];
    }

    public function toOptionStateArray()
    {
        $result = [];
        foreach ($this->toOptionStateData() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }
}
