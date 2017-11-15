<?php
namespace Riki\Wamb\Ui\Component\Listing\Column;

class Course extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Riki\SubscriptionCourse\Model\CourseFactory
     */
    protected $courseFactory;

    /**
     * @var \Riki\Wamb\Model\RuleRepository
     */
    protected $ruleRepository;

    /**
     * Course constructor.
     *
     * @param \Riki\Wamb\Model\Config\Source\CourseIds $courseIdsSource
     * @param \Riki\Wamb\Model\RuleRepository $ruleRepository
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Riki\SubscriptionCourse\Model\CourseFactory $courseFactory,
        \Riki\Wamb\Model\RuleRepository $ruleRepository,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->courseFactory = $courseFactory;
        $this->ruleRepository = $ruleRepository;
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
        if (!isset($dataSource['data']['items']) && is_array($dataSource['data']['items'])) {
            return $dataSource;
        }

        $courseData = [];

        $listItems = $this->courseFactory->create()->getCollection()->addFieldToFilter('is_enable',1);

        /** @var \Wyomind\PointOfSale\Model\PointOfSale $warehouse */
        foreach ($listItems as $course) {
            $courseData[$course->getId()] = $course->getCourseCode() . ' - ' . $course->getCourseName();
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (empty($item['rule_id'])) {
                continue;
            }

            $courseIds = $this->ruleRepository->createFromArray($item)->getCourseIds();

            $courseNames = array_intersect_key($courseData, array_flip($courseIds));

            $item['course_name'] = implode(', ', $courseNames);
        }

        return $dataSource;
    }
}