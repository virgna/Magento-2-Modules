<?php

namespace Magentochamp\ChProductImporter\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{  
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->_objectManager = $objectManager;
        $this->_resource = $resource;
        parent::__construct($context);
    }

    public function insertData($dataArr){
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $connection->insert('chproductimporter',$dataArr);
    }

    public function fetchData(){
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $query = " SELECT * FROM chproductimporter ORDER BY id DESC LIMIT 1";
        return $connection->fetchRow($query);
    }
}
