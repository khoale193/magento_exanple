<?php
namespace Isobar\DeliveryDate\Model\ResourceModel;

/**
 * Class Item
 * @package Isobar\DeliveryDate\Model\ResourceModel
 */
class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**#@+
     * Constants defined for keys of data array
     */
    const TABLE_NAME = 'isobar_delivery';
    const ENTITY_ID = 'id';

    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ENTITY_ID);
    }
}