<?php
namespace Isobar\DeliveryDate\Block;

use \Magento\Backend\Block\Template;
use \Magento\Framework\App\Request\Http;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Backend\Block\Template\Context;

/**
 * Class Order
 * @package Isobar\DeliveryDate\Block
 */
class Order extends Template
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
     * OrderBlock constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        Http $request,
        OrderRepositoryInterface $orderRepository,
        Context $context
    )
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    /**
     * @return array
     */
    function getDeliveryDate()
    {
        //get order_id from request
        $order_id = $this->request->getParam('order_id');
        //get order data by order id
        $order = $this->orderRepository->get($order_id);
        //set and return delivery data
        $data['delivery_date']= $order->getExtensionAttributes()->getDeliveryDate();
        $data['delivery_comment']= $order->getExtensionAttributes()->getDeliveryComment();

        return $data;
    }
}
