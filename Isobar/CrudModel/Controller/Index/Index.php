<?php
namespace Isobar\CrudModel\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Isobar\CrudModel\Model\EmployeeFactory
     */
    protected $employeeFactory;

    /**
     * @var \Isobar\CrudModel\Model\ResourceModel\Employee\CollectionFactory
     */
    protected $employeeCollectionFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Isobar\CrudModel\Model\EmployeeFactory $employeeFactory,
        \Isobar\CrudModel\Model\ResourceModel\Employee\CollectionFactory $employeeCollectionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;

        $this->employeeFactory = $employeeFactory;
        $this->employeeCollectionFactory = $employeeCollectionFactory;

        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /* ----- Create ----- */
        /** @var \Isobar\CrudModel\Model\Employee $employee */
        $employee = $this->employeeFactory->create();
        $employee
            ->setName('Nguyen Van C')
            ->setCreatedAt((new \DateTime())->getTimestamp())
            ->save();
        $employeeId = $employee->getId();

        /* ----- Retrieve ----- */
        $employee = $this->employeeFactory->create();
        $employee->load($employeeId);

        echo '<br />Get data just inserted<br />';
        var_dump($employee->getData());

        /* ----- Update ----- */
        /** @var \Isobar\CrudModel\Model\Employee $item */
        $employee = $this->employeeFactory->create();
        $employee
            ->load($employeeId)
            ->setUpdatedAt((new \DateTime())->getTimestamp())
            ->setName('Nguyen Van D')
            ->save();

        $employee = $this->employeeFactory->create();
        $employee->load($employeeId);

        echo '<br />Get data just updated<br />';
        var_dump($employee->getData());

        /** @var \Isobar\CrudModel\Model\Employee $employee */
        $employee = $this->employeeFactory->create();
        $employee
            ->setId($employeeId)
            ->setIsFemale(true)
            ->save();

        echo '<br />Get data just updated<br />';
        var_dump($employee->getData());

        /* ----- Delete ----- */
        /** @var \Isobar\CrudModel\Model\Employee $employee */
        $employee = $this->employeeFactory->create();
        $employee
            ->load(1)
            ->delete();

        /* ----- Delete 2 ----- */
        /** @var \Isobar\CrudModel\Model\Employee $employee */
        $employee = $this->employeeFactory->create();
        $employee
            ->setId(2)
            ->delete();

        /* ----- Get collection ----- */
        /** @var \Isobar\CrudModel\Model\ResourceModel\Employee\Collection $collection */
        $collection = $this->employeeCollectionFactory->create();
        $collection
            ->addFieldToSelect('*')
            //->addFieldToFilter('name', ['like' => '%4%'])
            ->load();

        foreach ($collection->getItems() as $item) {
            echo '<br />';
            var_dump($item->getData());

        }

        echo '<br />Done';

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
