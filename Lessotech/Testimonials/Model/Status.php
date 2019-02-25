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

namespace Lessotech\Testimonials\Model;

use Magento\Framework\Data\OptionSourceInterface;
 
class Status implements OptionSourceInterface
{
    /**
     * Get Grid row status type labels array.
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['0' => __('Disabled'),'1' => __('Enabled')];
        return $options;
    }
 
    /**
     * Get Grid row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    public function getReviewStatusesOptionArray()
    {
        $result = [];
        foreach ($this->getOptionArray() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }
 
    /**
     * Get Grid row type array for option element.
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
 
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
