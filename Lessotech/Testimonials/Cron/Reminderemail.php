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

namespace Lessotech\Testimonials\Cron;

use Magento\Framework\Mail\Template\TransportBuilder;
use Lessotech\Testimonials\Model\NotificationFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class Reminderemail
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Lessotech\Testimonials\Model\NotificationFactory
     */
    protected $modelNotificationFactory;

    /**
     * @var Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory
     */
    protected $colNotificationFactory;


    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param NotificationFactory $modelNotificationFactory
     * @param Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory $colNotificationFactory
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        NotificationFactory $modelNotificationFactory,
        \Lessotech\Testimonials\Model\ResourceModel\Notification\CollectionFactory $colNotificationFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {

        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->modelNotificationFactory = $modelNotificationFactory;
        $this->colNotificationFactory = $colNotificationFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->orderRepository = $orderRepository;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * get general store username
     *
     * @return String
     */
    public function getStorename()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_general/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * get general store email
     *
     * @return String
     */
    public function getStoreEmail()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_general/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        try {
            $baseUrl = $this->storeManager->getStore()->getBaseUrl();
            $colFactory = $this->colNotificationFactory->create()->addFieldToFilter('email_status', 0);
            if (!empty($colFactory)) {
                foreach ($colFactory as $value) {
                    $getOrder = $this->orderRepository->get($value->getOrderId());
                    $reviewUrl = $baseUrl.'testimonials/index/index/id/'.$value->getOrderId().'/';
                    $arrayName = ['name' => $getOrder->getData('customer_firstname'),'email' => $getOrder->getData('customer_email'),'reviewurl' => $reviewUrl,'orderid' => $value->getOrderId() ];
                    $transport = $this->transportBuilder->setTemplateIdentifier('send_email_email_template')
                    ->setTemplateOptions([ 'area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1 ])
                    ->setTemplateVars(['data' => new \Magento\Framework\DataObject($arrayName)])
                    ->setFrom([ "name" => $this->getStoreEmail(), "email" => $this->getStorename() ])
                    ->addTo($getOrder->getData('customer_email'))
                    ->setReplyTo($getOrder->getData('customer_email'))
                    ->getTransport();
                    $transport->sendMessage();

                    $updateModel = $this->modelNotificationFactory->create();
                    $updateModel->load($value->getId());
                    $updateModel->setEmailStatus(1);
                    $updateModel->save();
                }
            }
        } catch (LocalizedException $e) {
            return $e->getMessage();
        }
        return $this;
    }
}
