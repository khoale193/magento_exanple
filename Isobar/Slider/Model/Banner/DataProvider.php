<?php
namespace Isobar\Slider\Model\Banner;

use Magento\Framework\Filesystem;
use Isobar\Slider\Model\ResourceModel\Banner\CollectionFactory;
use Isobar\Slider\Model\ImageUploader;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Isobar\Slider\Model\ResourceModel\Banner\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Isobar\Slider\Model\ResourceModel\Banner\CollectionFactory $pageCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        ImageUploader $imageUploader,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $pageCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $basePath = $this->imageUploader->getBasePath();
        $baseUrl = $this->imageUploader->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        /** @var $banner \Isobar\Slider\Model\Banner */
        foreach ($items as $banner) {
            $bannerData = $banner->getData();

            if (!$bannerData['image_destination']) {
                unset($bannerData['image_destination']);
            } else {
                $name = $bannerData['image_destination'];
                unset($bannerData['image_destination']);
                $bannerData['image_destination'] = [];
                $bannerData['image_destination'][] = [
                    'name' => $name,
                    'url' => $baseUrl . $basePath . DIRECTORY_SEPARATOR . $name
                ];
            }

            $this->loadedData[$banner->getId()] = $bannerData;
        }

        return $this->loadedData;
    }
}
