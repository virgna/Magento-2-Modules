<?php

namespace Magentochamp\Interior\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    public function __construct(
    	\Magento\Framework\App\Helper\Context $context,
        array $data = []
    	)
    {
        parent::__construct($context, $data);
        //parent::__construct($context);
    }

    public function toOptionCityData()
    {
        return 
            ['1' => __('Ahmedabad'),'2' => __('Baroda'),'3' => __('Surat'),'4' => __('Mumbai'),'5' => __('Rest of India')];
    }

    public function getSpecialityCollectionData()
    {
        return 
            ['1' => __('Architect'),'2' => __('Designer'),'3' => __('Others')];
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
