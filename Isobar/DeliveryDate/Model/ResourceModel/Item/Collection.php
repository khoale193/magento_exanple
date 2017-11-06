<?php
namespace Isobar\DeliveryDate\Model\ResourceModel\Item;

/**
 * Class Collection
 * @package Isobar\DeliveryDate\Model\ResourceModel\Item
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Isobar\DeliveryDate\Model\Item', 'Isobar\DeliveryDate\Model\ResourceModel\Item');
    }
}
