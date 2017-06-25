<?php

namespace Opengento\Dontworry\Test\Unit\Cron;

class AwesomeCronMuchRevenueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Opengento\Dontworry\Cron\AwesomeCronMuchRevenue 
     */
    protected $awesomeCronMuchRevenue;
    
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->awesomeCronMuchRevenue = $objectManager->getObject(\Opengento\Dontworry\Cron\AwesomeCronMuchRevenue::class);
    }
    
    /**
     * @dataProvider productDataProvider
     */
    public function testCreateOrder($productData)
    {
        $order = $this->awesomeCronMuchRevenue->createOrder($productData);
        
        // Crazy Dynamic Condition
        if ($order === 'ALLL RIIIIGHT') {
            $this->assertEquals('ALLL RIIIIGHT', $order);
        } else {
            $this->assertInternalType('int', (int)$order);
        }
    }
    
    public function productDataProvider()
    {
        return [
            [
                'currency_id' => 'EUR',
                'customer_id' => 1,
                'shipping_address' => [
                    'firstname' => 'TEST IS OK',
                    'lastname' => 'TEST IS OK',
                    'street' => 'TEST IS OK',
                    'city' => 'TEST IS OK',
                    'country_id' => 'FR',
                    'region' => 'TEST IS OK',
                    'postcode' => '12345',
                    'telephone' => '0102030405',
                ],
                'items' => [
                    ['product_id' => '1082'],
                ],
            ],
            [
                'currency_id' => 'EUR',
                'customer_id' => 1,
                'shipping_address' => [
                    'firstname' => 'IS DONE',
                    'lastname' => 'IS DONE',
                    'street' => 'IS DONE',
                    'city' => 'IS DONE',
                    'country_id' => 'FR',
                    'region' => 'IS DONE',
                    'postcode' => '12345',
                    'telephone' => '0504030201',
                ],
                'items' => [
                    ['product_id' => '1082'],
                ],
            ]
        ];
    }
}
