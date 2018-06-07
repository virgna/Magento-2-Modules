<?php
namespace Magentochamp\Sellwithus\Model\ResourceModel\Sellwithus;
  
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
            'Magentochamp\Sellwithus\Model',
            'Magentochamp\Sellwithus\Model\ResourceModel\Model'
        );
    }*/
    protected function _construct()
    {
        $this->_init(
            'Magentochamp\Sellwithus\Model\Sellwithus',
            'Magentochamp\Sellwithus\Model\ResourceModel\Sellwithus'
        );
    }
}
