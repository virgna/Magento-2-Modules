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

namespace Lessotech\Testimonials\Block\Adminhtml\Grid\Edit;

/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    protected $_helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Lessotech\Testimonials\Model\Status $options,
        \Lessotech\Testimonials\Helper\Data $helper,
        array $data = []
    ) {
        $this->_options = $options;
        $this->_helper = $helper;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'customername',
            'label',
            [
                'name' => 'customername',
                'label' => __('Customer Name'),
                'id' => 'customername',
                'title' => __('Customer Name'),
            ]
        );

        $fieldset->addField(
            'city',
            'label',
            [
                'name' => 'city',
                'label' => __('City'),
                'id' => 'city',
                'title' => __('City'),
            ]
        );

        $fieldset->addField(
            'detailed-rating',
            'note',
            [
                'label' => __('Detailed Rating'),
                'text' => '<div id="rating_detail">' . $this->getLayout()->createBlock(
                    \Lessotech\Testimonials\Block\Adminhtml\Rating\Detailed::class
                )->toHtml() . '</div>'
            ]
        );

        /*$fieldset->addField(
            'logo_image', 'Uploaded Images', [
                'name' => 'photos',
                'label' => __('Uploaded Images'),
                'title' => __('Uploaded Images'),
                'renderer'  => 'Lessotech\Testimonials\Block\Adminhtml\Renderer\Image',
            ]
        );*/

        $fieldset->addField(
            'photos',
            'note',
            [
                'label' => __('Uploaded Images'),
                'text' => '<span id="uploaded_images">' . $this->getLayout()->createBlock(
                    \Lessotech\Testimonials\Block\Adminhtml\Rating\Images::class
                )->toHtml() . '</span>'
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'id' => 'status',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
