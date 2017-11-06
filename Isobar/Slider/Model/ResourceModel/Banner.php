<?php
namespace Isobar\Slider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Isobar\Slider\Setup\InstallSchema;

class Banner extends AbstractDb {

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(InstallSchema::LAKHOA_BANNER_TABLE, InstallSchema::LAKHOA_BANNER_ID);
    }

}
