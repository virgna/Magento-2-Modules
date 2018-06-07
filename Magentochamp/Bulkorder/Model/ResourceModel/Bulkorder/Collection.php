<?php
namespace Magentochamp\Bulkorder\Model\ResourceModel\Bulkorder;
  
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
  
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Define model & resource model
     */
    /*protected function _construct()
    {
        $this->_init(
            'Magentochamp\Bulkorder\Model',
            'Magentochamp\Bulkorder\Model\ResourceModel\Model'
        );
    }*/
    protected function _construct()
    {
        $this->_init(
            'Magentochamp\Bulkorder\Model\Bulkorder',
            'Magentochamp\Bulkorder\Model\ResourceModel\Bulkorder'
        );
    }
}
