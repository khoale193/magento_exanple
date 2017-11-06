<?php
namespace Isobar\CrudModel\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Isobar\CrudModel\Setup\InstallSchema;

class InstallData implements InstallDataInterface
{

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dateFormat = (new \DateTime())->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT);

        $data = [
            [InstallSchema::LAKHOA_EMPLOYEE_NAME => 'Le Anh Khoa',
                InstallSchema::LAKHOA_EMPLOYEE_CREATEDAT => $dateFormat,
                InstallSchema::LAKHOA_EMPLOYEE_UPDATEDAT => $dateFormat],
            [InstallSchema::LAKHOA_EMPLOYEE_NAME => 'Nguyen Van A',
                InstallSchema::LAKHOA_EMPLOYEE_CREATEDAT => $dateFormat,
                InstallSchema::LAKHOA_EMPLOYEE_UPDATEDAT => $dateFormat],
            [InstallSchema::LAKHOA_EMPLOYEE_NAME => 'Tran Van B',
                InstallSchema::LAKHOA_EMPLOYEE_CREATEDAT => $dateFormat,
                InstallSchema::LAKHOA_EMPLOYEE_UPDATEDAT => $dateFormat]
        ];

        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable(InstallSchema::LAKHOA_EMPLOYEE_TABLE), $bind);
        }
    }
}
