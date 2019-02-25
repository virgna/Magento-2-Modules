<?php
/**
 * Lessotech
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the lessotech.com license that is
 * available through the world-wide-web at this URL:
 * https://www.lessotech.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Lessotech
 * @package     Lessotech_Testimonials
 * @copyright   Copyright (c) Lessotech (http://www.lessotech.com/)
 * @license     http://www.lessotech.com/LICENSE.txt
 */

namespace Lessotech\Testimonials\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Captcha\Observer\CaptchaStringResolver;
use Lessotech\Testimonials\Model\NotificationFactory;

class TestimonialNotificationObserver implements ObserverInterface
{
    /**
     * @var Lessotech\Testimonials\Model\NotificationFactory
     */
    protected $modelNotificationFactory;

    /**
     * @param Lessotech\Testimonials\Model\NotificationFactory $modelNotificationFactory
     */
    public function __construct(
        NotificationFactory $modelNotificationFactory
    ) {
        $this->modelNotificationFactory = $modelNotificationFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $orderId = $observer->getEvent()->getData('order')->getId();
        $newData = ['order_id'=>$orderId,'email_status'=>0];
        $model = $this->modelNotificationFactory->create();
        $model->setData($newData);
        $model->save();
    }
}
