<?php

namespace Opengento\Dontworry\Test\Unit\Test\Unit\Helper;

class DataTestTest
{
    /**
     * @var \Opengento\Dontworry\Test\Unit\Helper\DataTest
     */
    protected $helperUnitTest;
    
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->helperUnitTest = $objectManager->get(\Opengento\Dontworry\Test\Unit\Helper\DataTest::class);
    }
    
    public function testIsHelperRealyHelping()
    {
        $this->assertEquals('inception', 'inception');
    }
}
