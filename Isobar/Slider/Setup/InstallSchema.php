<?php
namespace Isobar\Slider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    const LAKHOA_BANNER_TABLE = 'lakhoa_banner';
    const LAKHOA_BANNER_ID = 'id';
    const LAKHOA_BANNER_NAME = 'name';
    const LAKHOA_BANNER_URL = 'url';
    const LAKHOA_BANNER_ALT = 'alt';
    const LAKHOA_BANNER_STATUS = 'status';
    const LAKHOA_BANNER_ORDER = 'orders';
    const LAKHOA_BANNER_IMAGE_DESTINATION = 'image_destination';

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable(InstallSchema::LAKHOA_BANNER_TABLE))
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_ID,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_NAME,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Name')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_URL,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Url')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_ALT,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Alternative text')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_STATUS,
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => true],
                'Status')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_ORDER,
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => '0'],
                'Order')
            ->addColumn(
                InstallSchema::LAKHOA_BANNER_IMAGE_DESTINATION,
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Image destination')
            ->setComment('Banner management table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
