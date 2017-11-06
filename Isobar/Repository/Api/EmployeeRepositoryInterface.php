<?php
namespace Isobar\Repository\Api;

interface EmployeeRepositoryInterface
{
    public function save(\Isobar\Repository\Api\Data\EmployeeInterface $item);
    public function get($modelId);
    public function delete(\Isobar\Repository\Api\Data\EmployeeInterface $item);
    public function deleteById($itemId);
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}

