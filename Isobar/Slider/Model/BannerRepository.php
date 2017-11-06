<?php
namespace Isobar\Slider\Model;

use Isobar\Slider\Model\ResourceModel\Banner as ResourceBanner;
use Magento\Framework\Api\SearchCriteriaInterface;

class BannerRepository implements \Isobar\Slider\Api\BannerRepositoryInterface
{
    protected $bannerFactory;
    protected $resource;

    /**
     * @var ResourceBanner\CollectionFactory
     */
    protected $collectionFactory;
    protected $searchResultsFactory;
    protected $searchCriteriaBuilder;

    /**
     * BannerRepository constructor.
     * @param BannerFactory $bannerFactory
     * @param ResourceModel\Banner $resource
     * @param ResourceModel\Banner\CollectionFactory $collectionFactory
     * @param \Isobar\Slider\Api\Data\BannerSearchResultsInterface|\Isobar\Slider\Api\Data\BannerSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Isobar\Slider\Model\BannerFactory $bannerFactory,
        ResourceBanner $resource,
        \Isobar\Slider\Model\ResourceModel\Banner\CollectionFactory $collectionFactory,
        \Isobar\Slider\Api\Data\BannerSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->bannerFactory = $bannerFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param \Isobar\Slider\Api\Data\BannerInterface|Banner $banner
     * @return \Isobar\Slider\Api\Data\BannerInterface
     */
    public function save(\Isobar\Slider\Api\Data\BannerInterface $banner)
    {
        try {
            $this->resource->save($banner);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the page: %1', $exception->getMessage()),
                $exception
            );
        }
        return $banner;
    }

    public function getById($bannerId)
    {
        $banner = $this->bannerFactory->create();

        $this->resourceModel->load($banner, $bannerId);

        return $banner;
    }

    public function getActiveList()
    {
        /* @var \Magento\Framework\Api\SearchCriteria $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('status', true)->create();

        /** @var \Isobar\Slider\Api\Data\BannerSearchResultsInterface $dataSource */
        $dataSource = $this->getList($searchCriteria);
        return $dataSource;
    }

    public function delete(\Isobar\Slider\Api\Data\BannerInterface $model)
    {
        $this->resourceModel->delete($model);

        return true;
    }

    public function deleteById($itemId)
    {
        $model = $this->get($itemId);
        return $this->delete($model);
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Example\Repository\Model\ResourceModel\Item\Collection $collection */
        $collection = $this->collectionFactory->create();

        //Add filters from root filter group to the collection
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder(
                $field,
                ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
            );
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->load();

        /** @var \Isobar\Slider\Api\Data\BannerSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Isobar\Slider\Model\ResourceModel\Banner\Collection $collection
     * @return void
     */
    private function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Isobar\Slider\Model\ResourceModel\Banner\Collection $collection)
    {
        $fields = [];
        $conditions = [];

        foreach ($filterGroup->getFilters() as $filter) {
            $field = $filter->getField();
            $condition = $filter->getConditionType() ?: 'eq';
            $value = $filter->getValue();

            $fields[] = $field;
            $conditions[] = [$condition => $value];
        }

        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
}
