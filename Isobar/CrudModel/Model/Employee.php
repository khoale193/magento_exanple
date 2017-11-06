<?php
namespace Isobar\CrudModel\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel {

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Isobar\CrudModel\Model\ResourceModel\Employee');
    }
}
