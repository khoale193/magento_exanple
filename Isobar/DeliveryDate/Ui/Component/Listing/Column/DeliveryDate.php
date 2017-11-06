<?php
namespace Isobar\DeliveryDate\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class DeliveryDate
 * @package Isobar\DeliveryDate\Ui\Component\Listing\Column
 */
class DeliveryDate extends Column
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteria;

    /**
     * DeliveryDate constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $criteria
     * @param array $components
     * @param array $data
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, OrderRepositoryInterface $orderRepository, SearchCriteriaBuilder $criteria, array $components = [], array $data = [])
    {
        $this->orderRepository = $orderRepository;
        $this->searchCriteria = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                //get entity_id from item
                $order_id = $item["entity_id"];
                //if exist order_id => not order grid => using order_id for get order
                if (isset($item["order_id"])) {
                    $order_id = $item["order_id"];
                }
                //get order by order id
                $order = $this->orderRepository->get($order_id);
                //load delivery date
                $deliveryDate = $order->getExtensionAttributes()->getDeliveryDate();
                //set data for delivery date column
                $item[$this->getData('name')] = $deliveryDate;
            }
        }
        return $dataSource;
    }
}
