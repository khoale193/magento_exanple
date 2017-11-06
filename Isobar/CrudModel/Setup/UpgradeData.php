<?php
namespace Lakhoa\CrudModel\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Isobar\CrudModel\Setup\InstallSchema;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion() && version_compare($context->getVersion(), '0.0.2') < 0)
        {
            $table = $setup->getTable(InstallSchema::LAKHOA_EMPLOYEE_TABLE);

            $setup->getConnection()
                ->update($table, [InstallSchema::LAKHOA_EMPLOYEE_ISFEMALE => false]);
        }

        $setup->endSetup();
    }
}
