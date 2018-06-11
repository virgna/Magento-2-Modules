<?php
namespace Magentochamp\Complaint\Model;
  
use Magento\Framework\Model\AbstractModel;
use Magentochamp\Complaint\Api\Data\GridInterface;  
class Unresolved extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Magentochamp\Complaint\Model\ResourceModel\Unresolved');
    }
}
