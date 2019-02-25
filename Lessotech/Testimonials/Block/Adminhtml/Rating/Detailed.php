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
class Detailed extends \Magento\Backend\Block\Template
{
    /**
     * Testimonials detail template name
     *
     * @var string
     */
    protected $_template = 'Lessotech_Testimonials::rating/detailed.phtml';

    /**
     * Testimonials resource model
     *
     * @var \Lessotech\Testimonials\Model\TestimonialsFactory
     */
    protected $_ratingsFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Lessotech\Testimonials\Model\TestimonialsFactory $testimonialsFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Lessotech\Testimonials\Model\TestimonialsFactory $ratingsFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_ratingsFactory = $ratingsFactory;
    }

    /**
     * Get collection of ratings
     *
     * @return RatingCollection
     */
    public function getRating()
    {
        $getId = $this->getRequest()->getParam('id');
        if ($getId) {
            $ratingCollection = $this->_ratingsFactory->create();
            $ratingArray = [];
            $loadCollection = $ratingCollection->load($getId);
            if (!empty($loadCollection)) {
                foreach ($loadCollection as $rating) {
                    $ratingArray = $rating;
                }
                
                unset($ratingArray['id']);
                unset($ratingArray['customername']);
                unset($ratingArray['city']);
                unset($ratingArray['photos']);
                unset($ratingArray['comment']);
                unset($ratingArray['orderid']);
                unset($ratingArray['created_at']);
                unset($ratingArray['updated_at']);
                unset($ratingArray['status']);

                $tmpArray = [];
                $i = 1;
                foreach ($ratingArray as $data => $value) {
                    $tmpArray[$i]['rating_id'] = $i;
                    $tmpArray[$i]['rating_code'] = $data;
                    $tmpArray[$i]['value'] = $value;

                    $i++;
                }
                return $tmpArray;
            } else {
                return;
            }
        } else {
            return;
        }
    }
}
