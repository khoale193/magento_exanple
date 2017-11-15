<?php
namespace Riki\Wamb\Ui\Component\Listing\Column;

class Category extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Riki\Wamb\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * Category constructor.
     *
     * @param \Riki\Wamb\Model\RuleRepository $ruleRepository
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Riki\Wamb\Model\RuleRepository $ruleRepository,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $categoryData = [];

        $collection = $this->categoryFactory->create()
            ->getCollection()
            ->addAttributeToSelect('name');

        /** @var \Magento\Catalog\Model\Category */
        foreach ($collection as $category) {
            $categoryData[$category->getId()] = $category->getName();
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (empty($item['rule_id'])) {
                continue;
            }

            $categoryIds = $this->ruleRepository->createFromArray($item)->getCategoryIds();

            $categoryNames = array_intersect_key($categoryData, array_flip($categoryIds));

            $item['category_name'] = implode(', ', $categoryNames);
        }

        return $dataSource;
    }
}