<?php
namespace Isobar\QuickView\Controller\Index;

use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Controller\Result\JsonFactory;
use \Magento\Framework\UrlFactory;

/**
 * Class Refreshcart
 * @package Isobar\QuickView\Controller\Index
 */
class Refreshcart extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * RefreshCart constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        UrlFactory $urlFactory
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Ajax for refresh cart
     * @return $this|void
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }

        $result = array();

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}