<?php
namespace Magentochamp\ChProductImporter\Model\ResourceModel\ChProductImporter;
  
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
  
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Magentochamp\ChProductImporter\Model\ChProductImporter',
            'Magentochamp\ChProductImporter\Model\ResourceModel\ChProductImporter'
        );
    }
}
