<?php
namespace Isobar\DeliveryDate\Model\Order\Pdf;

/**
 * Class Shipment PDF model
 * @package Isobar\DeliveryDate\Model\Order\Pdf
 */
class Shipment extends \Magento\Sales\Model\Order\Pdf\Shipment
{
    /**
     * @var \Isobar\DeliveryDate\Api\ItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * Shipment constructor.
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Sales\Model\Order\Pdf\Config $pdfConfig
     * @param \Magento\Sales\Model\Order\Pdf\Total\Factory $pdfTotalFactory
     * @param \Magento\Sales\Model\Order\Pdf\ItemsFactory $pdfItemsFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Sales\Model\Order\Address\Renderer $addressRenderer
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param \Isobar\DeliveryDate\Api\ItemRepositoryInterface $itemRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Sales\Model\Order\Pdf\Config $pdfConfig,
        \Magento\Sales\Model\Order\Pdf\Total\Factory $pdfTotalFactory,
        \Magento\Sales\Model\Order\Pdf\ItemsFactory $pdfItemsFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Sales\Model\Order\Address\Renderer $addressRenderer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Isobar\DeliveryDate\Api\ItemRepositoryInterface $itemRepository,
        array $data = []
    )
    {
        $this->itemRepository = $itemRepository;
        parent::__construct(
            $paymentData,
            $string,
            $scopeConfig,
            $filesystem,
            $pdfConfig,
            $pdfTotalFactory,
            $pdfItemsFactory,
            $localeDate,
            $inlineTranslation,
            $addressRenderer,
            $storeManager,
            $localeResolver,
            $data
        );
    }

    /**
     * Return PDF document
     *
     * @param \Magento\Sales\Model\Order\Shipment[] $shipments
     * @return \Zend_Pdf
     */
    public function getPdf($shipments = [])
    {
        $this->_beforeGetPdf();
        $this->_initRenderer('shipment');

        $pdf = new \Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $this->_setFontBold($style, 10);
        foreach ($shipments as $shipment) {
            if ($shipment->getStoreId()) {
                $this->_localeResolver->emulate($shipment->getStoreId());
                $this->_storeManager->setCurrentStore($shipment->getStoreId());
            }
            $page = $this->newPage();
            $order = $shipment->getOrder();
            /* Add image */
            $this->insertLogo($page, $shipment->getStore());
            /* Add address */
            $this->insertAddress($page, $shipment->getStore());
            /* Add head */
            $this->insertOrder(
                $page,
                $shipment,
                $this->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_SHIPMENT_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );

            /* Add delivery date data */
            try {
                //get delivery date data by order id
                $deliverydate = $this->itemRepository->getByOrderId($order->getEntityId());
                $deliveryDate = $deliverydate->getDeliveryDate();
                $deliveryComment = $deliverydate->getDeliveryComment();
                //draw delivery date content
                $this->insertDeliveryDate($page, $this->y, $deliveryDate, $deliveryComment);

            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            }

            /* Add document text and number */
            $this->insertDocumentNumber($page, __('Packing Slip # ') . $shipment->getIncrementId());
            /* Add table */
            $this->_drawHeader($page);
            /* Add body */
            foreach ($shipment->getAllItems() as $item) {
                if ($item->getOrderItem()->getParentItem()) {
                    continue;
                }
                /* Draw item */
                $this->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
        }
        $this->_afterGetPdf();
        if ($shipment->getStoreId()) {
            $this->_localeResolver->revert();
        }
        return $pdf;
    }

    /**
     * draw deliverydate
     *
     * @param $page
     * @param $y
     * @param $deliveryDate
     * @param $deliveryComment
     */
    public function insertDeliveryDate(&$page, &$y, $deliveryDate, $deliveryComment)
    {
        $y += 8;
        $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
        $page->setLineWidth(0.5);
        //draw header border
        $page->drawRectangle(25, $y, 570, $y - 25);
        $y -= 15;

        $this->_setFontBold($page, 12);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        //draw text header
        $page->drawText(__('Delivery Date'), 35, $y, 'UTF-8');

        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.45));

        //parse delivery comment to array with each item is contain 110 char
        $arrDeliveryComment = str_split($deliveryComment, 110);
        //count total item
        $countDeliveryComment = count($arrDeliveryComment);
        //draw content border by add more height item * 15
        $page->drawRectangle(25, $y - 10, 570, $y - (70 + $countDeliveryComment * 15));

        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $this->_setFontRegular($page, 10);
        $y -= 25;
        //draw delivery date data
        $page->drawText('Delivery Date: ', 35, $y, 'UTF-8');
        $y -= 15;
        $page->drawText($deliveryDate, 35, $y, 'UTF-8');
        $y -= 15;
        //draw delivery comment data
        $page->drawText('Delivery Comment: ', 35, $y, 'UTF-8');
        $y -= 15;
        $arrDeliveryComment = str_split($deliveryComment, 110);
        //draw each item of delivery comment
        foreach ($arrDeliveryComment as $item) {
            $page->drawText($item, 35, $y, 'UTF-8');
            $y -= 15;
        }
        $y -= 7;
    }
}
