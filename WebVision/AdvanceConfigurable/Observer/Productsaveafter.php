<?php

namespace WebVision\AdvanceConfigurable\Observer;

use Magento\Framework\Event\ObserverInterface;

class Productsaveafter implements ObserverInterface
{    
	public function __construct(
	    \Magento\Framework\App\RequestInterface $request
	) { 
	    $this->_request = $request;
	}

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /*$_product = $observer->getProduct();
        $_sku=$_product->getSku();*/
        /*echo "<pre>";
        print_r($this->_request->getPost());
        die('called');*/

    }   
}