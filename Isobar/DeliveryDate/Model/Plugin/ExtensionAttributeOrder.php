<?php
namespace Isobar\DeliveryDate\Model\Plugin;

/**
 * Class ExtensionAttributeOrder
 * @package Isobar\DeliveryDate\Model\Plugin
 */
class ExtensionAttributeOrder
{
    /**
     * @var \Isobar\DeliveryDate\Api\ItemRepositoryInterface
     */
    protected $deliveryDateRepository;

    /**
     * ExtensionAttributeOrder constructor.
     * @param \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory
     * @param \Isobar\DeliveryDate\Api\ItemRepositoryInterface $deliveryDateRepository
     */
    public function __construct(
        \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory,
        \Isobar\DeliveryDate\Api\ItemRepositoryInterface $deliveryDateRepository
    )
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->deliveryDateRepository = $deliveryDateRepository;
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Api\Data\OrderInterface $order
    )
    {
        try {
            //get delivery date data by order id
            $data = $this->deliveryDateRepository->getByOrderId($order->getEntityId());
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return $order;
        }
        //get order extension attribute
        $orderExtension = $order->getExtensionAttributes();
        //if not exist => create new
        if ($orderExtension === null) {
            $orderExtension = $this->orderExtensionFactory->create();
        }
        //set data for order extension attribute
        $orderExtension->setDeliveryComment($data->getDeliveryComment());
        $orderExtension->setDeliveryDate($data->getDeliveryDate());
        //save extension attribute for order
        $order->setExtensionAttributes($orderExtension);
        return $order;
    }

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return \Isobar\DeliveryDate\Api\Data\ItemInterface|\Magento\Sales\Api\Data\OrderInterface
     */
    public function afterSave(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Api\Data\OrderInterface $order
    )
    {
        $quoteId = $order->getQuoteId();
        //get delivery date data by quote id
        $delivery = $this->deliveryDateRepository->getByQuoteId($quoteId);

        $orderId = $order->getEntityId();
        $delivery->setOrderId($orderId);
        $this->deliveryDateRepository->save($delivery);

        return $order;
    }
}
