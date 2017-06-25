<?php

namespace Opengento\Dontworry\Block\Catalog\Product\View;

use Magento\CatalogInventory\Model\StockRegistry;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class LastSales extends \Magento\Framework\View\Element\Template {

    protected $registry;
    protected $stockRegistry;
    protected $stockQty;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        StockRegistry $stockRegistry,
        array $data)
    {
        $this->registry = $registry;
        $this->stockRegistry = $stockRegistry;

        parent::__construct($context, $data);
    }

    /**
     * Count current users visiting this product page
     */
    public function getCurrentUserCount()
    {
        return $this->getStockQty() + rand(3, 30);
    }

    /**
     * Get current product qty
     */
    public function getStockQty()
    {
        if(!$this->stockQty)
        {
            $product = $this->getCurrentProduct();
            $stockItem = $this->stockRegistry->getStockItem($product->getId());

            $this->stockQty = (int) $stockItem->getQty();
        }

        return $this->stockQty;
    }

    /**
     * Get current product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
}