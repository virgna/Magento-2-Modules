<?php
namespace Magentochamp\Complaint\Model\ResourceModel\Complaint;
  
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
            'Magentochamp\Complaint\Model',
            'Magentochamp\Complaint\Model\ResourceModel\Model'
        );
    }*/
    protected function _construct()
    {
        $this->_init(
            'Magentochamp\Complaint\Model\Complaint',
            'Magentochamp\Complaint\Model\ResourceModel\Complaint'
        );
    }
}
