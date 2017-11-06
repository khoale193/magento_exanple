<?php
namespace Isobar\Slider\Model;

use Magento\Framework\Model\AbstractModel;
use Isobar\Slider\Api\Data\BannerInterface;

class Banner extends AbstractModel implements BannerInterface
{
    /**#@+
     * Banner's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Isobar\Slider\Model\ResourceModel\Banner::class);
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::BANNER_ID);
    }

    /**
     * Prepare banner's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::BANNER_NAME);
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getUrl()
    {
        return $this->_getData(self::BANNER_URL);
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->_getData(self::BANNER_ALT);
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->_getData(self::BANNER_STATUS);
    }

    /**
     * @return string
     */
    public function getImageDestination()
    {
        return $this->_getData(self::BANNER_IMAGE_DESTINATION);
    }

    public function getBannerUrl($attributeCode = 'image_destination')
    {
        $url = false;
        $image = $this->getData($attributeCode);
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'slider/banners/' . $image;
            }
//            else {
//                throw new \Magento\Framework\Exception\LocalizedException(
//                    __('Something went wrong while getting the image url.')
//                );
//            }
        }
        return $url;
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function setId($id) {
        return $this->setData(self::BANNER_ID, $id);
    }

    /**
     * Set name
     *
     * @return null
     */
    public function setName($name) {
        return $this->setData(self::BANNER_NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        return $this->setData(self::BANNER_URL, $url);
    }

    public function setAlt($alt)
    {
        return $this->setData(self::BANNER_ALT, $alt);
    }

    public function setStatus($status)
    {
        return $this->setData(self::BANNER_STATUS, $status);
    }

    public function setImagePath($imageDestination)
    {
        return $this->setData(self::BANNER_IMAGE_DESTINATION, $imageDestination);
    }

}
