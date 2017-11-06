<?php

namespace Isobar\DeliveryDate\Model;

/**
 * Class ItemRepository
 * @package Isobar\DeliveryDate\Model
 */
class ItemRepository implements \Isobar\DeliveryDate\Api\ItemRepositoryInterface
{
    /**
     * @var \Isobar\DeliveryDate\Model\ItemFactory
     */
    protected $modelFactory;

    /**
     * @var \Isobar\DeliveryDate\Model\ResourceModel\Item
     */
    protected $resourceModel;

    /**
     * @var \Isobar\DeliveryDate\Model\ResourceModel\Item\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Isobar\DeliveryDate\Api\Data\ItemSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * ItemRepository constructor.
     * @param \Isobar\DeliveryDate\Api\Data\ItemInterfaceFactory $modelFactory
     * @param ResourceModel\Item $resourceModel
     * @param ResourceModel\Item\CollectionFactory $collectionFactory
     * @param \Isobar\DeliveryDate\Api\Data\ItemSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Isobar\DeliveryDate\Api\Data\ItemInterfaceFactory $modelFactory,
        \Isobar\DeliveryDate\Model\ResourceModel\Item $resourceModel,
        \Isobar\DeliveryDate\Model\ResourceModel\Item\CollectionFactory $collectionFactory,
        \Isobar\DeliveryDate\Api\Data\ItemSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;

        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getByOrderId($orderId)
    {
        $model = $this->modelFactory->create();

        $filter = $this->filterBuilder
            ->create()
            ->setField(\Isobar\DeliveryDate\Api\Data\ItemInterface::ORDER_ID)
            ->setValue($orderId)
            ->setConditionType('eq');

        $filterGroup = $this->filterGroupBuilder
            ->addFilter($filter)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$filterGroup])
            ->create();

        $result = $this->getList($searchCriteria);
        $modelId = '';
        foreach ($result->getItems() as $item) {
            $modelId = $item->getId();
        }

        if (!$modelId) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested item doesn\'t exist'));
        }

        $this->resourceModel->load($model, $modelId);
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Isobar\DeliveryDate\Api\Data\ItemInterface $model)
    {
        try {
            $this->resourceModel->save($model);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__('Unable to save item'));
        }
    }

    /**
     * @param int $quoteId
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByQuoteId($quoteId)
    {
        $model = $this->modelFactory->create();

        $filter = $this->filterBuilder
            ->create()
            ->setField(\Isobar\DeliveryDate\Api\Data\ItemInterface::QUOTE_ID)
            ->setValue($quoteId)
            ->setConditionType('eq');

        $filterGroup = $this->filterGroupBuilder
            ->addFilter($filter)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$filterGroup])
            ->create();

        $result = $this->getList($searchCriteria);

        $modelId = '';
        foreach ($result->getItems() as $item) {
            $modelId = $item->getId();
        }

        if (!$modelId) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested item doesn\'t exist'));
        }

        $this->resourceModel->load($model, $modelId);
        return $model;
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Isobar\DeliveryDate\Model\ResourceModel\Item\Collection $collection */
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
     * @param \Isobar\DeliveryDate\Model\ResourceModel\Item\Collection $collection
     * @return void
     */
    private function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Isobar\DeliveryDate\Model\ResourceModel\Item\Collection $collection)
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