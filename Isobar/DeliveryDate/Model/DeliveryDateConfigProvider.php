<?php
namespace Isobar\DeliveryDate\Model;

class DeliveryDateConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Isobar\DeliveryDate\Api\ItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * DeliveryDateConfigProvider constructor.
     *
     * @param \Magento\Checkout\Model\Session $_checkoutSession
     * @param \Isobar\DeliveryDate\Api\ItemRepositoryInterface $itemRepository
     */
    public function __construct(
        \Magento\Checkout\Model\Session $_checkoutSession,
        \Isobar\DeliveryDate\Api\ItemRepositoryInterface $itemRepository
    )
    {
        $this->_checkoutSession = $_checkoutSession;
        $this->itemRepository = $itemRepository;
    }

    /**
     * get deliverydate
     *
     * @return array
     */
    public function getConfig()
    {
        $config = ['deliveryDateSSDB' => [
            'delivery_date' => '',
            'delivery_comment' => ''
        ]];

        try {
            $quoteId = $this->_checkoutSession->getQuote()->getEntityId();
            $deliveryDateData = $this->itemRepository->getByQuoteId($quoteId);

            $deliveryDate = $deliveryDateData->getDeliveryDate();
            $deliveryComment = $deliveryDateData->getDeliveryComment();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $deliveryDate = '';
            $deliveryComment = '';
        }

        $config['deliveryDateSSDB']['delivery_date'] = $deliveryDate;
        $config['deliveryDateSSDB']['delivery_comment'] = $deliveryComment;

        return $config;
    }
}
