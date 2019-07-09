<?php

namespace Onilab\CartPopup\Model;

class LastAddedItemRecord
{
    /**
     * @var \Magento\Quote\Model\Quote\Item|null
     */
    private $quoteItem = null;

    /**
     * @var \Magento\Catalog\Model\Product|null
     */
    private $product = null;

    /**
     * @return \Magento\Quote\Model\Quote\Item|null
     */
    public function getQuoteItem()
    {
        return $this->quoteItem;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item|null $quoteItem
     * @return self
     */
    public function setQuoteItem($quoteItem): self
    {
        $this->quoteItem = $quoteItem;
        return $this;
    }

    /**
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \Magento\Catalog\Model\Product|null $product
     * @return self
     */
    public function setProduct($product): self
    {
        $this->product = $product;
        return $this;
    }
}
