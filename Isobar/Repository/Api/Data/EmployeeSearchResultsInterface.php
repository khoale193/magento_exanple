<?php
namespace Isobar\Repository\Api\Data;

interface EmployeeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Isobar\Repository\Api\Data\EmployeeInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Isobar\Repository\Api\Data\EmployeeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
