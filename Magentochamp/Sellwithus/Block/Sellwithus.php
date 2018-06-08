<?php

namespace Magentochamp\Sellwithus\Block;

class Sellwithus extends \Magento\Framework\View\Element\Template
{
    protected $_helper;

    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        \Magentochamp\Sellwithus\Helper\Data $helper,
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
        return $this->getUrl('sellwithus/index/post');
    }
    
    public function toOptionCtypeArray()
    {
        return $this->_helper->toOptionCtypeData();
    }

    public function toOptionStateArray()
    {
        return $this->_helper->toOptionStateData();
    }
}