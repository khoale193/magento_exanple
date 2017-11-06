<?php
namespace Isobar\Slider\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $pageFactory;

    /* @var Registry $_coreRegistry */
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $resultPageFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        /**
         * @var \Isobar\Slider\Model\Banner $model
         */
        $model = $this->_objectManager->create(\Isobar\Slider\Model\Banner::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $titleTopPage = $this->getRequest()->getParam('redirect_title', 'Edit Banner Info');

        /**
         * @var Page $resultPage
         */
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set($titleTopPage);

        //$resultPage->setActiveMenu('Isobar_Slider::content_slider_banner');

        return $resultPage;
    }

}
