<?php
namespace Isobar\Slider\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BannerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get banners list.
     *
     * @return \Isobar\Slider\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * Set banners list.
     *
     * @param \Isobar\Slider\Api\Data\BannerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
