<?php
namespace Isobar\DeliveryDate\Block;

use \Magento\Backend\Block\Template;
use \Magento\Framework\App\Request\Http;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Sales\Api\ShipmentRepositoryInterface;
use \Magento\Backend\Block\Template\Context;

/**
 * Class Shipment
 * @package Isobar\DeliveryDate\Block
 */
class Shipment extends Template
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
     * @var \Magento\Sales\Api\ShipmentRepositoryInterface
     */
    protected $shipmentRepository;

    /**
     * ShipmentBlock constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Api\ShipmentRepositoryInterface $shipmentRepository
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        Http $request,
        OrderRepositoryInterface $orderRepository,
        ShipmentRepositoryInterface $shipmentRepository,
        Context $context
    )
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->shipmentRepository = $shipmentRepository;
        parent::__construct($context);
    }

    /**
     * @return array
     */
    function getDeliveryDate()
    {
        //get shipment_id from request
        $id = $this->request->getParam('shipment_id');
        //get shipment by id
        $shipment = $this->shipmentRepository->get($id);
        //get order id from invoice data
        $order_id = $shipment->getOrderId();
        //get order data by order id
        $order = $this->orderRepository->get($order_id);
        //set and return delivery data
        $data['delivery_date'] = $order->getExtensionAttributes()->getDeliveryDate();
        $data['delivery_comment'] = $order->getExtensionAttributes()->getDeliveryComment();

        return $data;
    }
}
