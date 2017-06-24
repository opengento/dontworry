<?php

namespace Opengento\Dontworry\Plugin\Catalog\Api\Data;

class ProductInterface
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $price)
    {
        $price = $price/10;
        return $price;
    }
}