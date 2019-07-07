<?php

namespace Onilab\CartPopup\Plugin;

class UpdateCartResponseModifier
{
    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    private $resultFactory;

    /**
     * UpdateCartResponseModifier constructor.
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     */
    public function __construct(
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param \Magento\Checkout\Controller\Cart\UpdateItemOptions $subject
     * @param mixed $result
     * @return mixed
     */
    public function afterExecute(
        \Magento\Checkout\Controller\Cart\UpdateItemOptions $subject,
        \Magento\Framework\Controller\ResultInterface $result
    ) {
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $subject->getRequest();
        /** @var \Magento\Framework\App\Response\Http */
        $response = $subject->getResponse();

        if (!$request->isAjax() ||
            !$response instanceof \Magento\Framework\App\Response\Http
        ) {
            return $result;
        }

        $result->renderResult($response);

        /** @var \Zend\Http\Header\Location $locationHeader */
        $locationHeader = $response->getHeader('Location');
        $response->clearHeader('location');
        $response->setHttpResponseCode(\Zend\Http\Response::STATUS_CODE_200);

        /** @var \Magento\Framework\Controller\Result\Json $jsonResult */
        $jsonResult = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);

        $jsonResult->setData(['backUrl' => $locationHeader->getUri()]);

        return $jsonResult;
    }
}
