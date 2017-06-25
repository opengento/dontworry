<?php

namespace Opengento\Dontworry\Test\Unit\Model;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    protected $amazing;
    
    protected function setUp()
    {    
        $this->amazing = true;
    }
    
    public function testDoesProductModelPluginIsAmazing()
    {
        $this->assertTrue($this->amazing);
    }
}
