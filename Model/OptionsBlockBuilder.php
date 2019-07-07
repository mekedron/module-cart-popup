<?php

namespace Onilab\CartPopup\Model;

class OptionsBlockBuilder
{
    /**
     * @var \Onilab\CartPopup\Model\LayoutResolver
     */
    private $layoutResolver;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * OptionsBlockBuilder constructor.
     *
     * @param LayoutResolver $layoutResolver
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Onilab\CartPopup\Model\LayoutResolver $layoutResolver,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Registry $registry
    ) {
        $this->layoutResolver = $layoutResolver;
        $this->productRepository = $productRepository;
        $this->registry = $registry;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function build($product)
    {
        if (!$product) {
            return '';
        }

        if ($product->getTypeId() === \Magento\Bundle\Model\Product\Type::TYPE_CODE) {
            $product->setCustomOptions([]);
        }

        $this->registry->register('product', $product);
        $this->registry->register('current_product', $product);

        $layout = $this->layoutResolver->getLayout();

        $layout->getUpdate()->addHandle('cart_popup_options_type_' . $product->getTypeId());

        /** @var \Onilab\CartPopup\Block\CartPopup\Options $optionsBlock */
        $optionsBlock = $layout->getBlock('cart_popup_options');

        return $optionsBlock->toHtml();
    }
}
