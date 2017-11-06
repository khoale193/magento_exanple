<?php
namespace Isobar\DeliveryDate\Plugin\Checkout\Model;

/**
 * Class ShippingInformationManagement
 * @package Isobar\DeliveryDate\Plugin\Checkout\Model
 */
class ShippingInformationManagement
{
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var \Isobar\DeliveryDate\Api\ItemRepositoryInterface
     */
    protected $deliveryDateRepository;

    /**
     * @var \Isobar\DeliveryDate\Api\Data\ItemInterfaceFactory
     */
    protected $deliveryDateFactory;

    /**
     * ShippingInformationManagement constructor.
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     * @param \Isobar\DeliveryDate\Api\ItemRepositoryInterface $deliveryDateRepository
     * @param \Isobar\DeliveryDate\Api\Data\ItemInterfaceFactory $deliveryDateFactory
     */
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Isobar\DeliveryDate\Api\ItemRepositoryInterface $deliveryDateRepository,
        \Isobar\DeliveryDate\Api\Data\ItemInterfaceFactory $deliveryDateFactory
    )
    {
        $this->deliveryDateFactory = $deliveryDateFactory;
        $this->quoteRepository = $quoteRepository;
        $this->deliveryDateRepository = $deliveryDateRepository;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    )
    {
        //get extension attribute
        $extAttributes = $addressInformation->getExtensionAttributes();
        //get delivery date extension attribute
        $deliveryDate = $extAttributes->getDeliveryDate();
        //get delivery comment extension attribute
        $deliveryComment = $extAttributes->getDeliveryComment();
        //get current cart
        $quote = $this->quoteRepository->getActive($cartId);

        try {
            //get delivery data by quote id
            $delivery = $this->deliveryDateRepository->getByQuoteId($quote->getEntityId());
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            //create delivery if not exist
            $delivery = $this->deliveryDateFactory->create();
        }

        if ($quote->getEntityId()) {
            //set delivery date data and save to tabel isobar_delivery
            $delivery
                ->setQuoteId($quote->getEntityId())
                ->setDeliveryDate($deliveryDate)
                ->setDeliveryComment($deliveryComment);
            $this->deliveryDateRepository->save($delivery);
        }
    }
}