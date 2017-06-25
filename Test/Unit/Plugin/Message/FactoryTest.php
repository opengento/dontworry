<?php

namespace Opengento\Dontworry\Test\Unit\Message;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $itWorks;
    
    protected function setUp()
    {    
        $this->itWorks = true;
    }
    
    public function testBeforeCreate()
    {
        $this->assertTrue($this->itWorks);
    }
}
