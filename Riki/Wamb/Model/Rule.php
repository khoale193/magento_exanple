<?php
namespace Riki\Wamb\Model;

use Riki\Wamb\Api\Data\RuleInterface;

class Rule extends \Magento\Framework\Model\AbstractModel implements RuleInterface
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(\Riki\Wamb\Model\ResourceModel\Rule::class);
    }

    /**
     * Get rule_id
     *
     * @return string|null
     */
    public function getRuleId()
    {
        return $this->getData(self::RULE_ID);
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get is_active
     *
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     *
     * @param string $isActive
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get min_purchase_qty
     *
     * @return string|null
     */
    public function getMinPurchaseQty()
    {
        return $this->getData(self::MIN_PURCHASE_QTY);
    }

    /**
     * Set min_purchase_qty
     *
     * @param string $minPurchaseQty
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setMinPurchaseQty($minPurchaseQty)
    {
        return $this->setData(self::MIN_PURCHASE_QTY, $minPurchaseQty);
    }

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created_date
     *
     * @param string $createdAt
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     *
     * @param string $updatedAt
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get category ids
     *
     * @return string[]
     */
    public function getCategoryIds()
    {
        if ($this->hasData(self::CATEGORY_IDS)) {
            return $this->getData(self::CATEGORY_IDS);
        }

        $conn = $this->getResource()->getConnection();
        $select = $conn->select()
            ->from($conn->getTableName('riki_wamb_rule_category'), ['category_id'])
            ->where('rule_id = ?', (int)$this->getRuleId());

        $result = $conn->fetchCol($select);

        $this->setData(self::CATEGORY_IDS, $result);

        return $result;
    }

    /**
     * Set category ids
     *
     * @param string[] $categoryIds
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setCategoryIds($categoryIds)
    {
        return $this->setData(self::CATEGORY_IDS, $categoryIds);
    }

    /**
     * Get course ids
     *
     * @return string[]
     */
    public function getCourseIds()
    {
        // TODO: Implement getCourseIds() method.
    }

    /**
     * Get course ids
     *
     * @param string[] $courseIds
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function setCourseIds($courseIds)
    {
        return $this->setData(self::COURSE_IDS, $courseIds);
    }
}