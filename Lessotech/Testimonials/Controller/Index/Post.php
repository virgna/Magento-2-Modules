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

namespace Lessotech\Testimonials\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Lessotech\Testimonials\Model\NotificationFactory;
use Magento\Framework\App\Action\Context;
use Lessotech\Testimonials\Model\TestimonialsFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Captcha\Helper\Data as CaptchaHelper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Magento\Framework\Stdlib\DateTime\DateTime;
     */
    protected $datetime;

    /**
     * @var Lessotech\Testimonials\Model\TestimonialsFactory;
     */
    protected $_modelTestimonialsFactory;

    /**
     * @var Magento\Framework\Mail\Template\TransportBuilder;
     */
    private $transportBuilder;

    /**
     * @var Magento\Framework\Translate\Inline\StateInterface;
     */
    protected $inlineTranslation;

    /**
     * @var \Lessotech\Testimonials\Helper\Data $helper;
     */
    protected $helper;

    /**
     * @var Lessotech\Testimonials\Model\NotificationFactory
     */
    protected $modelNotificationFactory;

    /**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $chelper;

    /**
     * @var \Magento\Captcha\Observer\CaptchaStringResolver
     */
    protected $captchaStringResolver;

    protected $uploaderFactory;
    protected $filesystem;
    protected $adapterFactory;

    /**
     * @param Context $context
     * @param TestimonialsFactory $modelTestimonialsFactory
     * @param NotificationFactory $modelNotificationFactory
     * @param Magento\Framework\Stdlib\DateTime\DateTime $datetime
     * @param Magento\Framework\Json\Helper\Data $jsonHelper
     * @param Magento\Framework\View\Result\PageFactory $resultFactory
     * @param CaptchaHelper $chelper
     * @param Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver
     * @param Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Context $context,
        TestimonialsFactory $modelTestimonialsFactory,
        NotificationFactory $modelNotificationFactory,
        \Lessotech\Testimonials\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\View\Result\PageFactory $resultFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        CaptchaHelper $chelper,
        \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver,
        TransportBuilder $transportBuilder,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->_modelTestimonialsFactory = $modelTestimonialsFactory;
        $this->modelNotificationFactory = $modelNotificationFactory;
        $this->jsonHelper = $jsonHelper;
        $this->chelper = $chelper;
        $this->resultFactory = $resultFactory;
        $this->datetime = $datetime;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->captchaStringResolver = $captchaStringResolver;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->adapterFactory = $adapterFactory;
    }

    public function execute()
    {



        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $response = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $model = $this->_modelTestimonialsFactory->create();
        $data = $this->getRequest()->getPostValue();

        $orderId = $data['orderid'];

        $data['photos'] = '';
        $files = $this->getRequest()->getFiles();
        if (isset($files->photos['name']) && $files->photos['name'] != '') {
            try {
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'photos']);

                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploaderFactory->setAllowRenameFiles(true);
                //$uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('testimonials/');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }

                $imagePath = 'testimonials/'.$result['file'];
                $data['photos'] = $imagePath;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        $newData = ['customername'=>$data['customername'],'city'=>$data['city'],'design_experience'=>$data['ratings'][1],'delivery_process'=>$data['ratings'][2],'quality'=>$data['ratings'][3],'photos'=>$data['photos'],'comment'=>$data['comments'],'created_at'=>$this->datetime->gmtDate(),'updated_at'=>$this->datetime->gmtDate(),'status'=>1];

        $model->setData($newData);
        try {
            $formId = 'testimonials';
            $captchaModel = $this->chelper->getCaptcha($formId);
            if (!$captchaModel->isCorrect($this->captchaStringResolver->resolve($this->getRequest(), $formId)) && $captchaModel->isRequired()) {
                $this->messageManager->addError(__('Incorrect CAPTCHA'));
            } else {
                $model->save();

                if ($orderId) {
                    $getOrderData = $this->helper->getOrderId($orderId);
                    $notificationId = $getOrderData['id'];
                    $updateModel = $this->modelNotificationFactory->create();
                    $updateModel->load($notificationId);
                    $updateModel->setTestimonialId($model->getId());
                    $updateModel->save();
                }

                $this->messageManager->addSuccessMessage('Testimonials has been submitted successfully');
            }
        } catch (LocalizedException $e) {
            $response->setHeader('Content-type', 'text/plain');
            $response->setContents(
                $this->jsonHelper->jsonEncode(
                    [
                        'result' => 'error',
                        'message' => $e->getMessage()
                    ]
                )
            );
        }
        $this->_redirect('testimonials');
    }
}
