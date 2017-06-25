<?php

namespace Opengento\Dontworry\Test\Unit\Model\Plugin\Catalog\Api\Data;

class ProductInterfactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Opengento\Dontworry\Plugin\Catalog\Api\Data\ProductInterface 
     */
    protected $afterPricePlugIn;
    
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $productMock;
    
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->afterPricePlugin = $objectManager->get(\Opengento\Dontworry\Plugin\Catalog\Api\Data\ProductInterface::class);
        $this->product = $this->getMock(\Magento\Catalog\Model\Product::class);
    }
    
    /**
     * @dataProvider pricesDataProvider
     */
    public function testAfterGetPrice($price)
    {
        $this->assertGreaterThan(0, $this->afterPricePlugin($this->afterPricePlugin, $price));
    }
    
    public function pricesDataProvider()
    {
        return [
            1, 10, 25, 65, 23, 21, 47, 82, 16, 42, 13, 65, 21, 23, 41, 62, 78, 9
        ];
    }
}
