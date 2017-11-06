<?php
namespace Isobar\Slider\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action;
use Isobar\Slider\Model\Banner;

class Save extends Action
{
    protected $imageUploader;

    /**
     * @var \Isobar\Slider\Model\BannerFactory
     */
    protected $bannerFactory;

    protected $bannerRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Isobar\Slider\Model\ImageUploader $imageUploader,
        \Isobar\Slider\Api\Data\BannerInterfaceFactory $bannerFactory,
        \Isobar\Slider\Api\BannerRepositoryInterface $bannerRepository
    ) {
        $this->imageUploader = $imageUploader;

        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            $banner = $this->bannerFactory->create();

            // Image
            $name = "";
            if (isset($data["image_destination"]) && is_array($data["image_destination"])) {
                $images = $data["image_destination"];
                foreach ($images as $image) {
                    $name = $image["name"];
                    // New file
                    if (isset($image["file"])) {
                        $this->imageUploader->moveFileFromTmp($name);
                        // Get only first
                        break;
                    }
                }
            }

            $banner->setData($data);
            $banner->setImagePath($name);

            $this->bannerRepository->save($banner);
            $this->messageManager->addSuccessMessage(__('Your banner saved.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
