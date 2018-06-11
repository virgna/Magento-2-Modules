<?php

namespace Magentochamp\Complaint\Block;

class Complaint extends \Magento\Framework\View\Element\Template
{
    protected $_helper;

    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
        \Magentochamp\Complaint\Helper\Data $helper,
        array $data = []
    	)
    {
        $this->_helper = $helper;
        parent::__construct($context, $data);
        //parent::__construct($context);
    }

    public function getFormAction()
    {
        return $this->getUrl('complaint/index/post');
    }
    
    public function getUnresolvedFormAction()
    {
        return $this->getUrl('complaint/index/unresolvedpost');
    }

    public function toOptionReasonData()
    {
        return $this->_helper->toOptionReasonData();
    }
}