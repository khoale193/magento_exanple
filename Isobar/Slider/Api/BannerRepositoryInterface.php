<?php
namespace Isobar\Slider\Api;

use Isobar\Slider\Api\Data\BannerInterface;

interface BannerRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param \Isobar\Slider\Api\Data\BannerInterface $banner
     * @return \Isobar\Slider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(BannerInterface $banner);

    /**
     * Retrieve banner.
     *
     * @param int $bannerId
     * @return \Isobar\Slider\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bannerId);

    /**
     * Retrieve banners matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Isobar\Slider\Api\Data\BannerSearchResultsInterfaceFactory
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete banner.
     *
     * @param \Isobar\Slider\Api\Data\BannerInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(BannerInterface $banner);

    /**
     * Delete banner by ID.
     *
     * @param int $bannerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bannerId);
}
