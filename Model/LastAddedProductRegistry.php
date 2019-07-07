<?php

namespace Onilab\CartPopup\Model;

class LastAddedProductRegistry
{
    /**
     * @var \Magento\Catalog\Model\Product|null
     */
    private $product = null;

    /**
     * @var \Magento\Quote\Model\Quote\Item|null
     */
    private $item = null;

    /**
     * @param \Magento\Catalog\Model\Product|null $product
     * @return $this
     */
    public function setProduct($product)
    {
        if ($product instanceof \Magento\Catalog\Model\Product) {
            $this->product = $product;
        } else {
            $this->product = null;
        }

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
     * @param \Magento\Quote\Model\Quote\Item|null $item
     * @return $this
     */
    public function setQuoteItem($item)
    {
        if ($item instanceof \Magento\Quote\Model\Quote\Item) {
            $this->item = $item;
        } else {
            $this->item = null;
        }

        return $this;
    }

    /**
     * @return \Magento\Quote\Model\Quote\Item|null
     */
    public function getQuoteItem()
    {
        return $this->item;
    }
}
