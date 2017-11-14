<?php
namespace Riki\Wamb\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema extends \Riki\Framework\Setup\Version\Schema implements InstallSchemaInterface
{
    public function version001()
    {
        // Create new Table: riki_wamb_rule
        $def = [
            [
                'rule_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'Rule ID'
            ],
            [
                'name',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Rule name'
            ],
            [
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                [
                    'default' => 0,
                    'nullable' => false
                ],
                'Is Active'
            ],
            [
                'min_purchase_qty',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false
                ],
                'Minimum purchase qty'
            ],
            [
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'default' => Table::TIMESTAMP_INIT_UPDATE
                ],
                'Created at'
            ],
            [
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'default' => Table::TIMESTAMP_INIT_UPDATE
                ],
                'Updated at'
            ]
        ];
        $this->createTable('riki_wamb_rule', $def);

        // Create new Table: riki_wamb_rule_category
        $def = [
            [
                'rule_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'Rule ID'
            ],
            [
                'category_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'Category ID (Ref to catalog_category_entity(entity_id))'
            ],
        ];
        $this->createTable('riki_wamb_rule_category', $def);
        $this->addForeignKey('riki_wamb_rule_category', 'category_id', 'catalog_category_entity', 'entity_id');
        $this->addForeignKey('riki_wamb_rule_category', 'rule_id', 'riki_wamb_rule', 'rule_id');

        // Create new Table: riki_wamb_rule_course
        $def = [
            [
                'rule_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'Rule ID'
            ],
            [
                'course_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'Course ID'
            ],
        ];
        $this->createTable('riki_wamb_rule_course', $def);
        $this->addForeignKey('riki_wamb_rule_course', 'rule_id', 'riki_wamb_rule', 'rule_id');
    }
}
