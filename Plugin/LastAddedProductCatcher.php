<?php

namespace Onilab\CartPopup\Plugin;

/**
 * Class LastAddedProductCatcher
 * @package Onilab\CartPopup\Plugin
 */
class LastAddedProductCatcher
{
    /**
     * @var \Onilab\CartPopup\Model\LastAddedProductRegistry
     */
    private $registry;

    /**
     * LastAddedProductCatcher constructor.
     * @param \Onilab\CartPopup\Model\LastAddedProductRegistry $registry
     */
    public function __construct(
        \Onilab\CartPopup\Model\LastAddedProductRegistry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @param \Magento\Quote\Model\Quote $subject
     * @param \Magento\Quote\Model\Quote\Item $parentItem
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\App\Request\Http $request
     * @return \Magento\Quote\Model\Quote\Item
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterAddProduct(
        \Magento\Quote\Model\Quote $subject,
        $parentItem,
        $product,
        $request
    ) {
        if ($product instanceof \Magento\Catalog\Model\Product) {
            $this->registry->setProduct($product);
        }

        if ($parentItem instanceof \Magento\Quote\Model\Quote\Item) {
            $this->registry->setQuoteItem($parentItem);
        }

        return $parentItem;
    }
}
