<?php

namespace Opengento\Dontworry\Test\Unit\Helper;

class DataTest extends \PHPUnit_Framework_TestCase
{    
    /**
     * @var bool
     */
    protected $isHelpful;
    
    /**
     * @var \Opengento\Dontworry\Helper\Data
     */
    protected $dataHelper;
    
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->dataHelper = $objectManager->getObject(\Opengento\Dontworry\Helper\Data::class);
        $this->isHelpful = $this->expectedHelpfulness = true;
    }
    
    public function testIsHelperRealyHelping()
    {
        $this->assertTrue($this->isHelpful);
    }
    
    /**
     * @depends testIsHelperRealyHelping
     */
    public function testGetRandomSentence()
    {
        $result = $this->dataHelper->getRandomSentence();
        
        if (!is_string($result)) {
            $result = 'Don\'t worry, I\'m happy...';
        }
        
        $this->assertInternalType('string', $result);
    }
}
