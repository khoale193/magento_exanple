<?php
namespace Riki\Wamb\Controller\Adminhtml\Rule;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_FORWARD);
        return $resultPage->forward('edit');
    }
}