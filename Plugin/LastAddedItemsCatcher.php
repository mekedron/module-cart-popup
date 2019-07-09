<?php

namespace Onilab\CartPopup\Plugin;

/**
 * Class LastAddedProductCatcher
 * @package Onilab\CartPopup\Plugin
 */
class LastAddedItemsCatcher
{
    /**
     * @var \Onilab\CartPopup\Model\LastAddedItemsStorage
     */
    private $itemsStorage;

    /**
     * LastAddedProductCatcher constructor.
     * @param \Onilab\CartPopup\Model\LastAddedItemsStorage $itemsStorage
     */
    public function __construct(
        \Onilab\CartPopup\Model\LastAddedItemsStorage $itemsStorage
    ) {
        $this->itemsStorage = $itemsStorage;
    }

    /**
     * Yeah, you got it right. Bundle or grouped products come here only once,
     * but this method can be called multiple times per request in the '24-UG06' page.
     * Guess why. Because of the checkboxed related products that nobody uses.
     *
     * @param \Magento\Quote\Model\Quote $subject
     * @param \Magento\Quote\Model\Quote\Item $parentItem
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Framework\App\Request\Http|null $request
     * @param string $processMode
     * @return \Magento\Quote\Model\Quote\Item
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterAddProduct(
        \Magento\Quote\Model\Quote $subject,
        $parentItem, // can be null
        $product,
        $request = null,
        $processMode = \Magento\Catalog\Model\Product\Type\AbstractType::PROCESS_MODE_FULL
    ) {
        // @TODO review this part, maybe we should use the fact that the $parentItem is string sometimes, haha
        $this->itemsStorage->addRecord(
            $parentItem instanceof \Magento\Quote\Model\Quote\Item ? $parentItem : null,
            $product instanceof \Magento\Catalog\Model\Product ? $product : null
        );

        return $parentItem;
    }
}
