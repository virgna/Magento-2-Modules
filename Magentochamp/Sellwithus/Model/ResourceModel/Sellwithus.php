<?php
namespace Magentochamp\Sellwithus\Model\ResourceModel;
  
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
  
class Sellwithus extends AbstractDb
{
	/**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;
 
    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime       $date
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) 
    {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('magentochamp_sellwithus', 'id');
    }
}
