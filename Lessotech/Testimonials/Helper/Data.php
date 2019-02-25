<?php

namespace Lessotech\Testimonials\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory
     */
    protected $colNotificationFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context  $context
     * @param \Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory $colNotificationFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory $colNotificationFactory
    ) {
        $this->colNotificationFactory = $colNotificationFactory;
        parent::__construct($context);
    }

    /**
     * Returns increment ID of Testimonials notification based on order id
     *
     * @return array
     */
    public function getOrderId($orderid = null)
    {
        $collection = $this->colNotificationFactory->create()
             ->addFieldToSelect(['id'])
             ->addFieldToFilter('order_id', $orderid);

        return $collection->getFirstItem();
    }
}
