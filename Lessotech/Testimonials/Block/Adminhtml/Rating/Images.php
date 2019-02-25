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

namespace Lessotech\Testimonials\Block\Adminhtml\Rating;

use Magento\Review\Model\Rating;
use Magento\Review\Model\Rating\Option;

/**
 * Adminhtml detailed rating stars
 */
class Images extends \Magento\Backend\Block\Template
{
    /**
     * Testimonials detail template name
     *
     * @var string
     */
    protected $_template = 'Lessotech_Testimonials::rating/images.phtml';

    /**
     * Testimonials resource model
     *
     * @var \Lessotech\Testimonials\Model\TestimonialsFactory
     */
    protected $_testimonialFactory;
    public $_storeManager;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Lessotech\Testimonials\Model\TestimonialsFactory $testimonialsFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Lessotech\Testimonials\Model\TestimonialsFactory $testimonialsFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_testimonialFactory = $testimonialsFactory;
        $this->_storeManager = $storeManager;
    }

    /**
     * Get collection of ratings
     *
     * @return TestimonialCollection
     */
    public function getImages()
    {
        $getId = $this->getRequest()->getParam('id');
        if ($getId) {
            $testimonialsCollection = $this->_testimonialFactory->create();
            $ratingArray = [];
            $loadCollection = $testimonialsCollection->load($getId);

            if (!empty($loadCollection)) {
                $images = $loadCollection['photos'];
                return $images;
            }
        }
    }
}
