<?php
namespace Riki\Wamb\Controller\Adminhtml\Rule;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Riki\Wamb\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * Delete constructor.
     * @param \Riki\Wamb\Model\RuleRepository $ruleRepository
     */
    public function __construct(
        \Riki\Wamb\Model\RuleRepository $ruleRepository,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->ruleRepository = $ruleRepository;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        $this->ruleRepository->deleteById($this->getRequest()->getParam('id', 0));

        return $resultRedirect->setPath('*/*/');
    }
}