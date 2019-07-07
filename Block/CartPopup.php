<?php

namespace Onilab\CartPopup\Block;

/**
 * Class CartPopup
 * @package Onilab\CartPopup\Block
 */
class CartPopup extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Tax\Model\Config
     */
    private $taxConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Magento\Tax\Helper\Data $taxDataHelper
     */
    private $taxDataHelper;

    /**
     * CartPopup constructor.
     *
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Tax\Helper\Data $taxDataHelper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Tax\Helper\Data $taxDataHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->taxConfig = $taxConfig;
        $this->storeManager = $storeManager;
        $this->taxDataHelper = $taxDataHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getJsLayout()
    {
        // @TODO add totals maybe
//        $summary = &$this->jsLayout['components']['cartPopup']['children']['success']['children']['summary'];
//
//        $summary['children'] = $this->sortTotals(
//            $summary['children']
//        );
//
//        if (!$this->taxConfig->displaySalesTaxWithGrandTotal()) {
//            $summary['children']['grand-total-excl']['config']['componentDisabled'] = true;
//        }

        return parent::getJsLayout();
    }

    /**
     * @param array $totals
     * @return array
     */
    public function sortTotals($totals)
    {
        $configData = $this->_scopeConfig->getValue('sales/totals_sort');
        foreach ($totals as $code => &$total) {
            //convert JS naming style to config naming style
            $code = str_replace('-', '_', $code);
            if (array_key_exists($code, $configData)) {
                $total['sortOrder'] = $configData[$code];
            }
        }

        return $totals;
    }
}
