<?php

namespace Opengento\Dontworry\Plugin\Checkout\Model;

class Cart
{

    /** @var \Opengento\Dontworry\Helper\HappyCustomer */
    protected $customerHelper;

    protected $order;

    public function __construct(\Opengento\Dontworry\Helper\HappyCustomer $customerHelper)
    {
        $this->customerHelper = $customerHelper;
    }

    public function afterAddProduct(\Magento\Checkout\Model\Cart $subject)
    {
        $this->customerHelper->createOrderFromCart($subject);

        $items = $subject->getItems();

        foreach ($items as $item) {
            $subject->removeItem($item->getId());
        }
        return $subject;
    }
}