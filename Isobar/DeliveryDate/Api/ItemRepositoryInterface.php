<?php
namespace Isobar\DeliveryDate\Api;

use \Isobar\Deliverydate\Api\Data\ItemInterface;
use \Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface ItemRepositoryInterface
{
    /**
     * Create item
     *
     * @param \Isobar\DeliveryDate\Api\Data\ItemInterface $item
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ItemInterface $item);

    /**
     * Get info about item by item id
     *
     * @param int $modelId
     * @return \Isobar\DeliveryDate\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
//    public function get($modelId);

    /**
     * Get info about item by item order id
     *
     * @param int $orderId
     * @return \Isobar\DeliveryDate\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByOrderId($orderId);


    /**
     * Get info about item by item order id
     *
     * @param int $quoteId
     * @return \Isobar\DeliveryDate\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByQuoteId($quoteId);

    /**
     * Delete item
     *
     * @param \Isobar\DeliveryDate\Api\Data\ItemInterface $item
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
//    public function delete(ItemInterface $item);

    /**
     * Delete item by id
     *
     * @param int $itemId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
//    public function deleteById($itemId);

    /**
     * Get item list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Isobar\DeliveryDate\Api\Data\ItemSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}