<?php

namespace Onilab\CartPopup\Model;

class LastAddedItemsStorage
{
    /**
     * @var \Onilab\CartPopup\Model\LastAddedItemRecord[]
     */
    private $records = [];
    /**
     * @var \Onilab\CartPopup\Model\LastAddedItemRecordFactory
     */
    private $recordFactory;

    /**
     * LastAddedItemsStorage constructor.
     * @param \Onilab\CartPopup\Model\LastAddedItemRecordFactory $addedItemRecordFactory
     */
    public function __construct(
        \Onilab\CartPopup\Model\LastAddedItemRecordFactory $addedItemRecordFactory
    ) {
        $this->recordFactory = $addedItemRecordFactory;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item|null $item
     * @param \Magento\Catalog\Model\Product|null $product
     * @return $this
     */
    public function addRecord(
        \Magento\Quote\Model\Quote\Item $item = null,
        \Magento\Catalog\Model\Product $product = null
    ) {
        /** @var \Onilab\CartPopup\Model\LastAddedItemRecord $record */
        $record = $this->recordFactory->create();
        $record->setQuoteItem($item);
        $record->setProduct($product);
        $this->records[] = $record;

        return $this;
    }

    /**
     * @return \Onilab\CartPopup\Model\LastAddedItemRecord[]
     */
    public function getRecords()
    {
        return $this->records;
    }
}
