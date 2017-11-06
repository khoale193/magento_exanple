<?php
namespace Isobar\DeliveryDate\Block;

use \Magento\Backend\Block\Template;
use \Magento\Framework\App\Request\Http;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Sales\Api\CreditmemoRepositoryInterface;
use \Magento\Backend\Block\Template\Context;

/**
 * Class Creditmemo
 * @package Isobar\DeliveryDate\Block
 */
class Creditmemo extends Template
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var \Magento\Sales\Api\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;

    /**
     * CreditmemoBlock constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        Http $request,
        OrderRepositoryInterface $orderRepository,
        CreditmemoRepositoryInterface $creditmemoRepository,
        Context $context
    )
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->creditmemoRepository = $creditmemoRepository;
        parent::__construct($context);
    }

    /**
     * get delivery_date, delivery_comment by creditmemo_id
     * @return array
     */
    function getDeliveryDate()
    {
        //get creditmemo_id from request
        $id = $this->request->getParam('creditmemo_id');
        //get creditmemo by id
        $creditmemo = $this->creditmemoRepository->get($id);
        //get order id from creditmemo data
        $order_id = $creditmemo->getOrderId();
        //get order data by order id
        $order = $this->orderRepository->get($order_id);
        //set and return delivery data
        $data['delivery_date'] = $order->getExtensionAttributes()->getDeliveryDate();
        $data['delivery_comment'] = $order->getExtensionAttributes()->getDeliveryComment();

        return $data;
    }
}
