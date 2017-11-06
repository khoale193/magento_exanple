<?php

namespace Isobar\DeliveryDate\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface ItemSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Isobar\DeliveryDate\Api\Data\ItemInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Isobar\DeliveryDate\Api\Data\ItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
