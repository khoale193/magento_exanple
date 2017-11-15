<?php
namespace Riki\Wamb\Controller\Adminhtml\Rule;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Riki\Wamb\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Riki\Wamb\Model\RuleRepository $ruleRepository,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->logger = $logger;
        $this->ruleRepository = $ruleRepository;
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id', 0);
        if ($id) {
            $model = $this->ruleRepository->getById($id);
        } else {
            $model = $this->ruleRepository->createFromArray();
        }

        /* @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magento_Customer::customer');
        $resultPage->getConfig()->getTitle()->prepend(__('WAMB Rule Management'));
//        $data = $this->_getSession()->getFormData(true);
//        if (!empty($data)) {
//            $model->setData($data);
//        }
//
        $this->registry->register('current_wamb_rule', $model);
        
        return $resultPage;
    }
}
