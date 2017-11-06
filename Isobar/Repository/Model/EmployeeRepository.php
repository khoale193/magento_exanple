<?php
namespace Isobar\Repository\Model;

class EmployeeRepository implements \Isobar\Repository\Api\EmployeeRepositoryInterface {

    protected $employeeFactory;
    protected $resourceModel;

    /**
     * EmployeeRepository constructor.
     * @param EmployeeFactory $employeeFactory
     * @param ResourceModel\Employee $resourceModel
     */
    public function __construct(
        \Isobar\Repository\Model\EmployeeFactory $employeeFactory,
        \Isobar\Repository\Model\ResourceModel\Employee $resourceModel)
    {
        $this->employeeFactory = $employeeFactory;
        $this->resourceModel = $resourceModel;
    }

    public function save(\Isobar\Repository\Api\Data\EmployeeInterface $item)
    {
        $this->resourceModel->save($item);
    }

    public function get($employeeId)
    {
        $employee = $this->employeeFactory->create();

        $this->resourceModel->load($employee, $employeeId);

        return $employee;
    }

    public function delete(\Isobar\Repository\Api\Data\EmployeeInterface $item)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($itemId)
    {
        // TODO: Implement deleteById() method.
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }
}