<?php
namespace Isobar\Repository\Model\ResourceModel\Employee;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Isobar\Repository\Model\Employee', 'Isobar\Repository\Model\ResourceModel\Employee');
    }
}
