<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magentochamp\ChProductImporter\Model\Config\Source;
use \Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;

class Frequency implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options array
     *
     * @var array
     */
    protected $_options;

    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '', 'label' => __('--Select Frequnecy--')], 
                ['value' => 'custom', 'label' => __('Use "custom export frequency" field')], 
                ['value' => '*/5 * * * *', 'label' => __('Every 5 Minutes')], 
                ['value' => '*/10 * * * *', 'label' => __('Every 10 Minutes')], 
                ['value' => '*/15 * * * *', 'label' => __('Every 15 Minutes')], 
                ['value' => '*/20 * * * *', 'label' => __('Every 20 Minutes')], 
                ['value' => '*/25 * * * *', 'label' => __('Every 25 Minutes')], 
                ['value' => '*/30 * * * *', 'label' => __('Every 30 Minutes')], 
                ['value' => '0 * * * *', 'label' => __('Every Hour')], 
                ['value' => '0 */2 * * *', 'label' => __('Every 2 Hour')], 
                ['value' => '0 0 * * *', 'label' => __('Daily (at midnight)')], 
                ['value' => '0 0,12 * * *', 'label' => __('Twice Daily (12am, 12pm)')]
            ];
        }
        return $this->_options;
    }
}
