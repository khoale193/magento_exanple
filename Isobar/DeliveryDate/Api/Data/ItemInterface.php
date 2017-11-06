<?php

namespace Isobar\DeliveryDate\Api\Data;

use \Magento\Framework\Api\ExtensibleDataInterface;

/**
 * @api
 */
interface ItemInterface //extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ORDER_ID = 'order_id';
    const QUOTE_ID = 'quote_id';
    const DELIVERY_DATE = 'delivery_date';
    const DELIVERY_COMMENT = 'delivery_comment';

    /**#@-*/

    /**
     * Get item id
     * @return int|null
     */
    public function getId();

    /**
     * Set item id
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int|null
     */
    public function getQuoteId();

    /**
     * @param $quote_id
     * @return $this
     */
    public function setQuoteId($quote_id);

    /**
     * @return int|null
     */
    public function getOrderId();

    /**
     * @param $order_id
     * @return $this
     */
    public function setOrderId($order_id);

    /**
     * @return string
     */
    public function getDeliveryDate();

    /**
     * @param $delivery_date
     * @return $this
     */
    public function setDeliveryDate($delivery_date);

    /**
     * @return string
     */
    public function getDeliveryComment();

    /**
     * @param $delivery_comment
     * @return $this
     */
    public function setDeliveryComment($delivery_comment);
}