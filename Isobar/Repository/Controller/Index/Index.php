<?php
namespace Isobar\Repository\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends Action {

    protected $resultPageFactory;

    protected $employeeFactory;

    protected $employeeRepository;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Isobar\Repository\Api\Data\EmployeeInterfaceFactory $employeeFactory
     * @param \Isobar\Repository\Api\EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Isobar\Repository\Api\Data\EmployeeInterfaceFactory $employeeFactory,
        \Isobar\Repository\Api\EmployeeRepositoryInterface $employeeRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;

        $this->employeeFactory = $employeeFactory;
        $this->employeeRepository = $employeeRepository;

        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /* ----- Create ----- */
        /** @var \Isobar\Repository\Api\Data\EmployeeInterface $employee */
        $employee = $this->employeeFactory->create();
        $employee
            ->setName('Name 1')
            ->setCreatedAt((new \DateTime())->getTimestamp());

        $this->employeeRepository->save($employee);var_dump(123);

        $employeeId = $employee->getId();

        /* ----- Retrieve ----- */
        $employee = $this->employeeRepository->get($employeeId);
        var_dump($employee->getData());

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
