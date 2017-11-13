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
        return $this->initForwardResult()->forward('edit');
    }
}
