<?php
namespace Magentochamp\Interior\Model\ResourceModel\Interior;
  
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
            'Magentochamp\Interior\Model',
            'Magentochamp\Interior\Model\ResourceModel\Model'
        );
    }*/
    protected function _construct()
    {
        $this->_init(
            'Magentochamp\Interior\Model\Interior',
            'Magentochamp\Interior\Model\ResourceModel\Interior'
        );
    }
}
