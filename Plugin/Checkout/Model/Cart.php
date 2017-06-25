<?php

namespace Opengento\Dontworry\Plugin\Checkout\Model;

class Cart
{

    /** @var \Opengento\Dontworry\Helper\HappyCustomer */
    protected $customerHelper;

    protected $order;

    protected $quote;

    public function __construct(
        \Opengento\Dontworry\Helper\HappyCustomer $customerHelper,
        \Magento\Quote\Model\Quote $quote)
    {
        $this->customerHelper = $customerHelper;
        $this->quote = $quote;
    }

    public function afterAddProduct(\Magento\Checkout\Model\Cart $subject)
    {
        $this->customerHelper->createOrderFromProductId($subject->getCheckoutSession()->getLastAddedProductId());

        $subject->setQuote($this->quote);

        return $subject;
    }
}