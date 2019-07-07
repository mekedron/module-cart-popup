<?php

namespace Onilab\CartPopup\Model;

/**
 * Class RelatedProductsBlockGenerator
 *
 * @package Onilab\CartPopup\Model
 */
class RelatedProductsBlockBuilder
{
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    private $layoutResolver;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * AddRelatedProductsBlock constructor.
     *
     * @param \Onilab\CartPopup\Model\LayoutResolver $layoutResolver
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Onilab\CartPopup\Model\LayoutResolver $layoutResolver,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->layoutResolver = $layoutResolver;
        $this->logger = $logger;
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

        // TODO add related products renderer
//        $block = $this->layoutResolver->getLayout()->getBlock('cart_popup_related_products');

//        try {
//            $block->setProduct($product);
//        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
//            $this->logger->critical(
//                'Can\'t find product ' . $product->__toString() . ' while generation Related Products Block',
//                ['exception' => $exception]
//            );
//            return '';
//        }

        return '';//returntrim($block->toHtml());
    }
}
