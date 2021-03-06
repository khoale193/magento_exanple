<?php
namespace Riki\Wamb\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'rule_id';

    protected function _construct()
    {
        $this->_init(\Riki\Wamb\Model\Rule::class, \Riki\Wamb\Model\ResourceModel\Rule::class);
    }
}