<?php

namespace Magentochamp\Complaint\Helper;

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

    public function toOptionReasonData()
    {
        return 
            ['1' => __('Product Query'),'2' => __('Order Related'),'3' => __('Coupons Query'),'4' => __('Delivery Related'),'5' => __('Return Item'),'6' => __('Account Related Query'),'7' => __('Website Feedback'),'8' => __('Others')];
    }

    public function getReasonOptionArray()
    {
        $result = [];
        foreach ($this->toOptionReasonData() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }
}
