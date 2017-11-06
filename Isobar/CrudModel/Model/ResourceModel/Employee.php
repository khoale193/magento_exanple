<?php
namespace Isobar\CrudModel\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Isobar\CrudModel\Setup\InstallSchema;

class Employee extends AbstractDb {

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::LAKHOA_EMPLOYEE_TABLE, InstallSchema::LAKHOA_EMPLOYEE_ID);
    }
}
