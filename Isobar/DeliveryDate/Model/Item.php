<?php

namespace Isobar\DeliveryDate\Model;

/**
 * Class Item
 * @package Isobar\DeliveryDate\Model
 */
class Item extends \Magento\Framework\Model\AbstractExtensibleModel implements \Isobar\DeliveryDate\Api\Data\ItemInterface
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Isobar\DeliveryDate\Model\ResourceModel\Item');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->_getData('id');
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData('id', $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuoteId()
    {
        return $this->_getData(self::QUOTE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setQuoteId($quote_id)
    {
        return $this->setData(self::QUOTE_ID, $quote_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId()
    {
        return $this->_getData(self::ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId($order_id)
    {
        return $this->setData(self::ORDER_ID, $order_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliveryDate()
    {
        return $this->_getData(self::DELIVERY_DATE);
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliveryDate($delivery_date)
    {
        return $this->setData(self::DELIVERY_DATE, $delivery_date);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliveryComment()
    {
        return $this->_getData(self::DELIVERY_COMMENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliveryComment($delivery_comment)
    {
        return $this->setData(self::DELIVERY_COMMENT, $delivery_comment);
    }

    /**
     * {@inheritdoc}
     */
//    public function getExtensionAttributes()
//    {
//        $extensionAttributes = $this->_getExtensionAttributes();
//        if (!$extensionAttributes) {
//            return $this->extensionAttributesFactory->create('Isobar\DeliveryDate\Api\Data\ItemInterface');
//        }
//        return $extensionAttributes;
//    }

    /**
     * {@inheritdoc}
     */
//    public function setExtensionAttributes(\Isobar\DeliveryDate\Api\Data\ItemExtensionInterface $extensionAttributes)
//    {
//        return $this->_setExtensionAttributes($extensionAttributes);
//    }
}