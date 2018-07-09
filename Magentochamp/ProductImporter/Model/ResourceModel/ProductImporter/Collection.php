<?php
namespace Entrepids\ProductImporter\Model\ResourceModel\ProductImporter;
  
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
  
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Entrepids\ProductImporter\Model\ProductImporter',
            'Entrepids\ProductImporter\Model\ResourceModel\ProductImporter'
        );
    }
}
