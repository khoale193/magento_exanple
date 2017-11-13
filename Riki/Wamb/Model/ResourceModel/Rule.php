<?php
namespace Riki\Wamb\Model\ResourceModel;

class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('riki_wamb_rule', 'rule_id');
    }
}