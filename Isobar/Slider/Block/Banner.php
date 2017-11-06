<?php
namespace Isobar\Slider\Block;

use Magento\Framework\Api\SortOrder;
use Isobar\Slider\Api\BannerRepositoryInterface;
use Isobar\Slider\Model\ImageUploader;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Api\SortOrderBuilder;

class Banner extends Template
{
    /**
     * @var \Isobar\Slider\Model\BannerRepository BannerRepositoryInterface
     */
    protected $bannerRepository;
    protected $imageUploader;
    protected $filterBuilder;
    protected $filterGroupBuilder;
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $sortOrderBuilder;
    /**
     * BannerShow constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param BannerRepositoryInterface $bannerRepository
     * @param ImageUploader $imageUploader
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        BannerRepositoryInterface $bannerRepository,
        ImageUploader $imageUploader,
        array $data,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        SortOrderBuilder $sortOrderBuilder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        parent::__construct($context, $data);
        $this->bannerRepository = $bannerRepository;
        $this->imageUploader = $imageUploader;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Load banner
     * @param bool $all Default is only get active banner
     * @return array
     */
    public function getBanners($all = false)
    {
        //filter status eq 1
        $filter = $this->filterBuilder
            ->create()
            ->setField('status')
            ->setValue(1);

        $filterGroup = $this->filterGroupBuilder
            ->addFilter($filter)
            ->create();

        //order by position asc
        $sortOrder = $this->sortOrderBuilder
            ->setField('orders')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$filterGroup])
            ->setSortOrders([$sortOrder])
            ->create();

        $items = $this->bannerRepository->getList($searchCriteria);

        $baseTmpPath = $this->imageUploader->getBasePath() . '/';
        $this->imageUploader->getBaseUrl();
        $loadData = [];
        foreach ($items->getItems() as $index => $item) {
            $banner = $item->getData();
            $url = $this->_storeManager
                    ->getStore()
                    ->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $baseTmpPath . $banner['image_destination'];
            $banner['image_destination'] = [
                'src' => $url,
                'name' => $banner['image_destination'],
                'alt' => isset($banner['alt']) ? $banner['alt'] : '',
                'href' => isset($banner['url']) ? $banner['url'] : '#'
            ];
            $loadData[] = $banner;
        }
        return $loadData;
    }
}
