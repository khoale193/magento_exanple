<?php
namespace Riki\Wamb\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class RuleActions
 */
class RuleActions extends Column
{
    const URL_PATH_EDIT = 'riki_wamb/rule/edit';
    const URL_PATH_DETAILS = 'riki_wamb/rule/view';
    const URL_PATH_DELETE = 'riki_wamb/rule/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['id' => $item['rule_id']]),
                        'label' => __('Edit')
                    ],
                    'view' => [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DETAILS, ['id' => $item['rule_id']]),
                        'label' => __('View')
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['rule_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $item['name']),
                            'message' => __('Are you sure you want to delete a %1 record?', $item['name'])
                        ]
                    ]
                ];
            }
        }

        return $dataSource;
    }
}