<?php

namespace Magentochamp\Interior\Helper;

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

    public function toOptionCityData()
    {
        return 
            ['1' => __('Ahmedabad'),'2' => __('Baroda'),'3' => __('Surat'),'4' => __('Mumbai'),'5' => __('Rest of India')];
    }

    public function getCityOptionArray()
    {
        $result = [];
        foreach ($this->toOptionCityData() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }
}
