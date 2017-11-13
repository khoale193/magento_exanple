<?php
namespace Riki\Wamb\Controller\Adminhtml\Rule;

class Edit extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context
    )
    {
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $id = $this->getRequest()->getParam('id', 0);
            if ($id) {
                $model = $this->ruleRepository->getById($id);
            } else {
                $model = $this->ruleRepository->createFromArray();
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred, please try again!'));
            $this->logger->critical($e);
        }

        if (!isset($model)) {
            $resultRedirect = $this->initRedirectResult();
            return $resultRedirect->setPath('*/*/');
        }

        $resultPage = $this->initPageResult();
        $resultPage->getConfig()->getTitle()->prepend(__('WAMB Rule Management'));
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->registry->register('current_wamb_rule', $model);

        return $resultPage;
    }
}
