<?php
namespace Isobar\CrudModel\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Isobar\CrudModel\Model\Employee', 'Isobar\CrudModel\Model\ResourceModel\Employee');
    }
}
