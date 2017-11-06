<?php
namespace Isobar\Slider\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;

class Add extends Action
{
    /* @var \Magento\Framework\Controller\Result\ForwardFactory $resultPageFactory */
    protected $resultForwardFactory;

    /**
     * Add constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    )
    {
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->setParams(['redirect_title' => 'Add Banner']);
        $resultForward->forward('edit');
        return $resultForward;
    }
}