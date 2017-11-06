<?php
namespace Isobar\CrudModel\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    const LAKHOA_EMPLOYEE_TABLE = 'lakhoa_employee';
    const LAKHOA_EMPLOYEE_ID = 'id';
    const LAKHOA_EMPLOYEE_NAME = 'name';
    const LAKHOA_EMPLOYEE_CREATEDAT = 'created_at';
    const LAKHOA_EMPLOYEE_UPDATEDAT = 'updated_at';
    const LAKHOA_EMPLOYEE_ISFEMALE = 'is_female';

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable(InstallSchema::LAKHOA_EMPLOYEE_TABLE))
            ->addColumn(
                InstallSchema::LAKHOA_EMPLOYEE_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id')
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Name')
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Created At')
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Updated At')
            ->setComment('Example Crud Model Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
