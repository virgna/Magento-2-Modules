<?php
/**
 * Magentochamp_Sellwithus Add New Row Form Admin Block.
 * @category    Magentochamp
 * @package     Magentochamp_Sellwithus
 * @author      Magentochamp Software Private Limited
 *
 */
namespace Magentochamp\Sellwithus\Block\Adminhtml\Grid\Edit;
 
 
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
        \Magentochamp\Sellwithus\Model\Status $options,
        \Magentochamp\Sellwithus\Helper\Data $helper,
        array $data = []
    ) 
    {
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
            'firstname',
            'text',
            [
                'name' => 'firstname',
                'label' => __('First Name'),
                'id' => 'firstname',
                'title' => __('First Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'lastname',
            'text',
            [
                'name' => 'lastname',
                'label' => __('Last Name'),
                'id' => 'lastname',
                'title' => __('Last Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'companytype',
            'multiselect',
            [
                'name' => 'companytype[]',
                'label' => __('Company Type'),
                'id' => 'companytype',
                'title' => __('Company Type'),
                'values' => $this->_helper->toOptionCtypeArray(),
                'class' => 'companytype',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'address',
            'textarea',
            [
                'name' => 'address',
                'label' => __('Address'),
                'id' => 'address',
                'title' => __('Address'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'companyname',
            'text',
            [
                'name' => 'companyname',
                'label' => __('Company Name'),
                'id' => 'companyname',
                'title' => __('Company Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'id' => 'email',
                'title' => __('Email'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'mobno',
            'text',
            [
                'name' => 'mobno',
                'label' => __('Mobile No'),
                'id' => 'mobno',
                'title' => __('Mobile No'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'pincode',
            'text',
            [
                'name' => 'pincode',
                'label' => __('Pincode'),
                'id' => 'pincode',
                'title' => __('Pincode'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'city',
            'text',
            [
                'name' => 'city',
                'label' => __('City'),
                'id' => 'city',
                'title' => __('City'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'state',
            'select',
            [
                'name' => 'state',
                'label' => __('State'),
                'id' => 'state',
                'title' => __('State'),
                'values' => $this->_helper->toOptionStateArray(),
                'class' => 'state',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'category',
            'select',
            [
                'name' => 'category',
                'label' => __('Category'),
                'id' => 'category',
                'title' => __('Category'),
                'values' => $this->_helper->getCategoryCollectionArr(),
                'class' => 'category',
                'required' => true,
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
                'required' => true,
            ]
        );
 
        /*$wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);
 
        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'style' => 'height:36em;',
                'required' => true,
                'config' => $wysiwygConfig
            ]
        );*/
 
        /*$fieldset->addField(
            'publish_date',
            'date',
            [
                'name' => 'publish_date',
                'label' => __('Publish Date'),
                'date_format' => $dateFormat,
                'time_format' => 'HH:mm:ss',
                'class' => 'validate-date validate-date-range date-range-custom_theme-from',
                'class' => 'required-entry',
                'style' => 'width:200px',
            ]
        );*/
        /*$fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'id' => 'is_active',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );*/
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
 
        return parent::_prepareForm();
    }
}