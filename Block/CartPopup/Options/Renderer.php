<?php

namespace Onilab\CartPopup\Block\CartPopup\Options;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Renderer extends \Magento\Swatches\Block\Product\Renderer\Configurable
{
    /**
     * @var \Magento\Framework\Locale\Format
     */
    private $localeFormat;

    /**
     * @var \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices
     */
    private $variationPrices;

    /**
     * Swatch constructor.
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\ConfigurableProduct\Helper\Data $helper
     * @param \Magento\Catalog\Helper\Product $catalogProduct
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\ConfigurableProduct\Model\ConfigurableAttributeData $confAttrData
     * @param \Magento\Swatches\Helper\Data $swatchHelper
     * @param \Magento\Swatches\Helper\Media $swatchMediaHelper
     * @param array $data
     * @param \Magento\Swatches\Model\SwatchAttributesProvider|null $swatchAttrProvider
     * @param \Magento\Framework\Locale\Format|null $localeFormat
     * @param \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices|null $variationPrices
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\ConfigurableProduct\Helper\Data $helper,
        \Magento\Catalog\Helper\Product $catalogProduct,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\ConfigurableProduct\Model\ConfigurableAttributeData $confAttrData,
        \Magento\Swatches\Helper\Data $swatchHelper,
        \Magento\Swatches\Helper\Media $swatchMediaHelper,
        array $data = [],
        \Magento\Swatches\Model\SwatchAttributesProvider $swatchAttrProvider = null,
        \Magento\Framework\Locale\Format $localeFormat = null,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices $variationPrices = null
    ) {
        parent::__construct(
            $context,
            $arrayUtils,
            $jsonEncoder,
            $helper,
            $catalogProduct,
            $currentCustomer,
            $priceCurrency,
            $confAttrData,
            $swatchHelper,
            $swatchMediaHelper,
            $data,
            $swatchAttrProvider
        );
        $this->localeFormat = $localeFormat ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
            \Magento\Framework\Locale\Format::class
        );
        $this->variationPrices = $variationPrices ?: \Magento\Framework\App\ObjectManager::getInstance()->get(
            \Magento\ConfigurableProduct\Model\Product\Type\Configurable\Variations\Prices::class
        );
    }

    /**
     * @return string
     */
    protected function getRendererTemplate()
    {
        return $this->_template;
    }

    /**
     * Composes configuration for js price format
     *
     * @return string
     */
    public function getPriceFormatJson()
    {
        return $this->jsonEncoder->encode($this->localeFormat->getPriceFormat());
    }

    /**
     * Composes configuration for js price
     *
     * @return string
     */
    public function getPricesJson()
    {
        return $this->jsonEncoder->encode(
            $this->variationPrices->getFormattedPrices($this->getProduct()->getPriceInfo())
        );
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return 'cart-popup-' . parent::getCacheKey();
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        $result = parent::getIdentities();

        if (!empty($result)) {
            $result[] = 'cart_popup';
        }

        return $result;
    }
}
