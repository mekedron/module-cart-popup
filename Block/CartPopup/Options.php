<?php

namespace Onilab\CartPopup\Block\CartPopup;

/**
 * @TODO REMOVE THIS CLASS
 *
 * Class Options
 * @package Onilab\CartPopup\Block\CartPopup
 */
class Options extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    private $formKey;

    /**
     * Configurable constructor.
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Catalog\Block\Product\Context $context,
        array $data = []
    ) {
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
