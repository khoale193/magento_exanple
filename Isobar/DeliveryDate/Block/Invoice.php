<?php
namespace Isobar\DeliveryDate\Block;

use \Magento\Backend\Block\Template;
use \Magento\Framework\App\Request\Http;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Sales\Api\InvoiceRepositoryInterface;
use \Magento\Backend\Block\Template\Context;

/**
 * Class Invoice
 * @package Isobar\DeliveryDate\Block
 */
class Invoice extends Template
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
     * @var \Magento\Sales\Api\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * InvoiceBlock constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository
     * @param \Magento\Backend\Block\Template\Context $context
     */
    public function __construct(
        Http $request,
        OrderRepositoryInterface $orderRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        Context $context
    )
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;
        parent::__construct($context);
    }

    /**
     * @return array
     */
    function getDeliveryDate()
    {
        //get invoice_id from request
        $id = $this->request->getParam('invoice_id');
        //get invoice by id
        $invoice = $this->invoiceRepository->get($id);
        //get order id from invoice data
        $order_id = $invoice->getOrderId();
        //get order data by order id
        $order = $this->orderRepository->get($order_id);
        //set and return delivery data
        $data['delivery_date'] = $order->getExtensionAttributes()->getDeliveryDate();
        $data['delivery_comment'] = $order->getExtensionAttributes()->getDeliveryComment();

        return $data;
    }
}
