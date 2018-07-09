<?php

namespace Entrepids\ProductImporter\Helper;

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

    public function readTable($runId = ''){
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $entrepidsIfProducts = $connection->fetchAll("select * from entrepids_if_products where runId = 2 ");
        $entrepidsIfProductsImport = $connection->fetchRow("select runId from entrepids_if_products_import ORDER BY id DESC LIMIT 1 ");
        $lastRunId = $entrepidsIfProductsImport['runId'];

        $transArray = array();
        foreach($entrepidsIfProducts as $prod){
            $transArray['sku'] = $prod['sku'];
            $transArray['name'] = $prod['name'];
            $transArray['product_online'] = $prod['product_online'];
            $transArray['product_type'] = 'default';
            $transArray['attribute_set_code'] = 'simple';
            $transArray['price'] = 1;
            $transArray['product_websites'] = $prod['product_websites'];
            $transArray['weight'] = $prod['weight'];
            $transArray['runId'] = $prod['runId'];
            $transArray['description'] = $prod['description'];
            $transArray['short_description'] = $prod['short_description'];
            $transArray['errors'] = $prod['errors'];
            if($lastRunId != $prod['runId']){
                $connection->insert('entrepids_if_products_import',$transArray);
            }
        }
//        
        die;
    }
    
}
