<?php

namespace Opengento\Dontworry\Cron;

class AwesomeCronMuchRevenue
{
  private $logger;
  private $cartManagementInterface;
  private $storeManager;
  private $productRepository;
  private $quote;
  private $quoteManagement;
  private $customerRepository;
  private $orderService;
  private $cartRepositoryInterface;
  private $orderRepository;

  public function __construct(
    \Psr\Log\LoggerInterface $logger,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Catalog\API\ProductRepositoryInterface $productRepository,
    \Magento\Sales\API\OrderRepositoryInterface $orderRepository,
    \Magento\Quote\Model\QuoteFactory $quote,
    \Magento\Quote\Model\QuoteManagement $quoteManagement,
    \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
    \Magento\Sales\Model\Service\OrderService $orderService,
    \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
    \Magento\Quote\Api\CartManagementInterface $cartManagementInterface
  )
  {
    $this->logger = $logger;
    $this->storeManager = $storeManager;
    $this->productRepository = $productRepository;
    $this->quote = $quote;
    $this->quoteManagement = $quoteManagement;
    $this->customerRepository = $customerRepository;
    $this->orderService = $orderService;
    $this->cartRepositoryInterface = $cartRepositoryInterface;
    $this->cartManagementInterface = $cartManagementInterface;
    $this->orderRepository = $orderRepository;
  }

  public function createOrder($orderData)
  {
    $store = $this->storeManager->getStore(1);
    $this->storeManager->setCurrentStore($store);
    $customer = $this->customerRepository->getById($orderData['customer_id']);

    $cartId = $this->cartManagementInterface->createEmptyCart();
    $cart = $this->cartRepositoryInterface->get($cartId);
    $cart->setStore($store);

    $cart->setCurrency();
    $cart->assignCustomer($customer);

    foreach ($orderData['items'] as $item) {
      $product = $this->productRepository->getById($item['product_id']);
      $cart->addProduct(
        $product,
        rand(1, 10)
      );
    }

    $cart->getBillingAddress()->addData($orderData['shipping_address']);
    $cart->getShippingAddress()->addData($orderData['shipping_address']);

    $shippingAddress = $cart->getShippingAddress();
    $shippingAddress->setCollectShippingRates(true)
      ->collectShippingRates()
      ->setShippingMethod('flatrate_flatrate');

    $cart->setPaymentMethod('checkmo');
    $cart->setInventoryProcessed(false);
    $cart->getPayment()->importData(['method' => 'checkmo']);
    $cart->collectTotals();
    $cart->save();
    $cart = $this->cartRepositoryInterface->get($cart->getId());

    $orderId = $this->cartManagementInterface->placeOrder($cart->getId());

    $order = $this->orderRepository->get($orderId);
    $order->setState(\Magento\Sales\Model\Order::STATE_COMPLETE, true);
    $order->setStatus(\Magento\Sales\Model\Order::STATE_COMPLETE);
    $order->save();

    if ($orderId) {
      $result = $orderId;
    } else {
      $result = 'ALLL RIIIIGHT';
    }

    return $result;
  }

  public function execute()
  {
    $this->logger->info('This CRON will do awesome things');

    $orderData = [
      'currency_id' => 'EUR',
      'customer_id' => 1,
      'shipping_address' => [
        'firstname' => 'TODO',
        'lastname' => 'TODO',
        'street' => 'TODO',
        'city' => 'TODO',
        'country_id' => 'FR',
        'region' => 'TODO',
        'postcode' => '12345',
        'telephone' => '0102030405',
      ],
      'items' => [
        ['product_id' => '1082'],
      ],
    ];

    $this->createOrder($orderData);
    $this->logger->info('This CRON has done awesome things');
  }
}
