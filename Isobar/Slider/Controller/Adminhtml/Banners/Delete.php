<?php
namespace Isobar\Slider\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action;

class Delete extends Action
{
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            // init model and delete
            $model = $this->_objectManager->create(\Isobar\Slider\Model\Banner::class);
            $model->load($id);
            $title = $model->getTitle();
            $model->delete();

            // display success message
            $this->messageManager->addSuccess(__('The banner has been deleted.'));

            // go to grid
            return $resultRedirect->setPath('*/*/');
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a banner to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
