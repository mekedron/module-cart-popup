<?php

namespace Onilab\CartPopup\Helper;

class CartPopupData extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Tax\Helper\Data $taxDataHelper
     */
    private $taxDataHelper;

    /**
     * CartPopupData constructor.
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Tax\Helper\Data $taxDataHelper
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Tax\Helper\Data $taxDataHelper,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->storeManager = $storeManager;
        $this->taxDataHelper = $taxDataHelper;
        parent::__construct($context);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPriceFormat()
    {
        return $this->taxDataHelper->getPriceFormat($this->storeManager->getStore()->getId());
    }

    /**
     * @return string
     */
    public function getCartUrl()
    {
        return $this->_getUrl('checkout/cart');
    }
}
