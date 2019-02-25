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

namespace Lessotech\Testimonials\Block;

class Testimonials extends \Magento\Framework\View\Element\Template
{
    /**
     * Testimonials Helper
     *
     * @var \Lessotech\Testimonials\Helper\Data
     */
    protected $_helper;

    /**
     * orderRepository
     *
     * @var \Lessotech\Testimonials\Helper\Data
     */
    protected $orderRepository;

    /**
     * @param Magento\Framework\View\Element\Template\Context $context
     * @param Lessotech\Testimonials\Helper\Data $helper
     * @param Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Lessotech\Testimonials\Helper\Data $helper,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->_helper = $helper;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Returns Form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('testimonials/index/post');
    }

    /**
     * Returns Order detail by ID
     *
     * @var $id
     *
     * @return array
     */
    public function getOrder($id)
    {
        return $this->orderRepository->get($id);
    }
}
