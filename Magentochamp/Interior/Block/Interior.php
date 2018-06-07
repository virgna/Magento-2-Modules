<?php

namespace Magentochamp\Interior\Block;

class Interior extends \Magento\Framework\View\Element\Template
{
    protected $_helper;

    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        \Magentochamp\Interior\Helper\Data $helper,
        array $data = []
    	)
    {
        $this->_helper = $helper;
        parent::__construct($context, $data);
        //parent::__construct($context);
    }

    public function getCategoryCollection()
    {
        return $this->_helper->getCategoryCollectionData();
    }

    public function getFormAction()
    {
        return $this->getUrl('interior/index/post');
    }
    
    public function toOptionArray()
    {
        return $this->_helper->toOptionCityData();
    }
}