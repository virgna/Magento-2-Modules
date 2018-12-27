<?php
/**
 * MageMeister Inc.
 *
 * NOTICE OF LICENSE
 *
 * <!--LICENSETEXT-->
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://magemeister.com for more information.
 *
 * @category    MageMeister
 * @package     MageMeister_EggEaster
 * @copyright   Copyright (c) 2013-2018 MageMeister Inc. (http://magemeister.com)
 * @author      Virang Jethva <virang.jethva@magemeister.com>
 * @info        MageMeister Inc. <hello@magemeister.com>
 */

namespace MageMeister\EggEaster\Ui\Component\Listing\Grid\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use MageMeister\EggEaster\Model\Status as StatusSource;

/**
 * Class Status
 *
 * @api
 * @since 100.1.0
 */
class Status extends Column implements OptionSourceInterface
{
    /**
     * @var StatusSource
     * @since 100.1.0
     */
    protected $source;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StatusSource $source
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StatusSource $source,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->source = $source;
    }

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);
        $options = $this->source->getOptionArray();

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($options[$item['status']])) {
                $item['status'] = $options[$item['status']];
            }
        }

        return $dataSource;
    }

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function toOptionArray()
    {
        return $this->source->getReviewStatusesOptionArray();
    }
}
