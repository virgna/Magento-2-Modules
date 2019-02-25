<?php
namespace Lessotech\Testimonials\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Exception\LocalizedException;

class Uploadfile extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Magento\Framework\Filesystem
     */
    protected $fileSystem;

    /**
     * @var Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * allowed extensions
     */
    protected $allowedExtensions = ['png','jpeg','jpg'];

    /**
     * @var file id for file upload identity
     */
    protected $fileId = 'filename';

    public function __construct(
        Filesystem $fileSystem,
        UploaderFactory $uploaderFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\View\Result\PageFactory $resultFactory
    ) {
        $this->fileSystem = $fileSystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->jsonHelper = $jsonHelper;
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();

        $destinationPath = $this->getDestinationPath();
        $files = $this->getRequest()->getFiles();

        if (!empty($files)) {
            $filename =  $files->filename['name'];
        }
        try {
            if ($filename) {
                $uploader = $this->uploaderFactory->create(['fileId' => $this->fileId])
                    ->setAllowCreateFolders(true)
                    ->setAllowedExtensions($this->allowedExtensions)
                    ->addValidateCallback('validate', $this, 'validateFile');
                if (!$uploader->save($destinationPath)) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
            }

            // pass data to phtml file
            /** @var \Magento\Framework\View\Result\Page $resultPage */
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

            /** @var \Magento\Framework\Controller\Result\Raw $response */
            $response = $this->resultFactory->create(ResultFactory::TYPE_RAW);

            $response->setHeader('Content-type', 'text/plain');
            $response->setContents(
                $this->jsonHelper->jsonEncode(
                    [
                        'filename' => $uploader->getUploadedFileName(),
                        'fullfilename' => 'testimonials/'.$uploader->getUploadedFileName(),
                        'filetype' => pathinfo($uploader->getUploadedFileName(), PATHINFO_EXTENSION)
                    ]
                )
            );
            return $response;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }

    /**
     *
     * return destination path for file upload
     *
     * @return string
     */
    public function getDestinationPath()
    {
        return $this->fileSystem
            ->getDirectoryWrite(DirectoryList::MEDIA)
            ->getAbsolutePath('testimonials/');
    }
}
