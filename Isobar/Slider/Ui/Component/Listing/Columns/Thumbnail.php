<?php
namespace Isobar\Slider\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Isobar\Slider\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Isobar\Slider\Model\ImageUploader $imageUploader
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Isobar\Slider\Model\ImageUploader $imageUploader,

        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageUploader = $imageUploader;
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
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';

                if ($item[$fieldName] != '') {
                    $url = $this->imageUploader->getBaseUrl() . $this->imageUploader->getBasePath() . DIRECTORY_SEPARATOR . $item[$fieldName];
                }

                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['alt'];
            }

        }

        return $dataSource;
    }
}
