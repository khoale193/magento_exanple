<?php
namespace Riki\Wamb\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

class RuleRepository implements \Riki\Wamb\Api\RuleRepositoryInterface
{
    /**
     * @var \Riki\Wamb\Model\RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var \Riki\Wamb\Api\Data\RuleSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * RuleRepository constructor.
     *
     * @param \Riki\Wamb\Model\RuleFactory $ruleFactory
     * @param \Riki\Wamb\Api\Data\RuleSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Riki\Wamb\Model\RuleFactory $ruleFactory,
        \Riki\Wamb\Api\Data\RuleSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Riki\Wamb\Api\Data\RuleInterface $rule)
    {
        try {
            $rule->save();
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rule: %1',
                $exception->getMessage()
            ));
        }

        return $rule;
    }

    /**
     * Get Rule entity by [rule_id]
     *
     * @var int $ruleId
     * @return \Riki\Wamb\Model\Rule
     * @throws NoSuchEntityException
     */
    public function getById($ruleId)
    {
        $rule = $this->ruleFactory->create();
        $rule->load($ruleId);
        if (!$rule->getRuleId()) {
            throw new NoSuchEntityException(__('Rule with id "%1" does not exist.', $ruleId));
        }

        return $rule;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $collection = $this->ruleFactory->create()->getCollection();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());var_dump($collection->getItems());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Riki\Wamb\Api\Data\RuleInterface $rule)
    {
        try {
            $rule->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Rule: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($ruleId)
    {
        return $this->delete($this->getById($ruleId));
    }

    /**
     * {@inheritdoc}
     *
     * @param array $data
     *
     * @return \Riki\Wamb\Api\Data\RuleInterface
     */
    public function createFromArray($data = [])
    {
        return $this->ruleFactory->create()->addData($data);
    }
}