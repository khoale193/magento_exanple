<?php
namespace Riki\Wamb\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Riki\Wamb\Api\Data\RuleInterface;
use Riki\Wamb\Api\RuleRepositoryInterface;

class Save extends Action
{
    /**
     * @var \Riki\Wamb\Model\Rule
     */
    protected $ruleFactory;

    /**
     * @var \Riki\Wamb\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * Save constructor.
     * @param \Riki\Wamb\Api\Data\RuleInterfaceFactory $ruleInterfaceFactory
     * @param RuleRepositoryInterface $ruleRepository
     * @param Action\Context $context
     */
    public function __construct(
        \Riki\Wamb\Api\Data\RuleInterfaceFactory $ruleInterfaceFactory,
        \Riki\Wamb\Api\RuleRepositoryInterface $ruleRepository,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->ruleFactory = $ruleInterfaceFactory;
        $this->ruleRepository = $ruleRepository;
        parent::__construct($context);
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $postValue = $this->getRequest()->getPostValue();
        $ruleId = isset($postValue['rule_id']) ? $postValue['rule_id'] : 0;
        try {
            $rule = $this->ruleRepository->getById($ruleId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $rule = $this->ruleRepository->createFromArray($postValue);
        }
        $rule->addData($postValue);

        $this->ruleRepository->save($rule);
        return $resultRedirect->setPath('*/*/');
    }
}