<?php
namespace Isobar\Repository\Model\ResourceModel;

use Isobar\CrudModel\Setup\InstallSchema;

/**
 * Item resource model
 */
class Employee extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::LAKHOA_EMPLOYEE_TABLE, InstallSchema::LAKHOA_EMPLOYEE_ID);
    }

}
