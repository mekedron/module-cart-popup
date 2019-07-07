<?php

namespace Onilab\CartPopup\Model;

class LayoutResolver
{
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    private $layout;

    /**
     * @var bool
     */
    private $prepared = false;

    /**
     * LayoutResolver constructor.
     * @param \Magento\Framework\View\LayoutInterface $layout
     */
    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * Add needed update handles and generate layout
     *
     * @return \Magento\Framework\View\LayoutInterface
     */
    public function getLayout()
    {
        if ($this->prepared === false) {
            $this->layout->getUpdate()->addHandle('cart_popup');
            $this->prepared = true;
        }

        return $this->layout;
    }
}
