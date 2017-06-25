<?php

namespace Opengento\Dontworry\Helper;

use Psr\Log\LoggerInterface;

class HappyCustomer
{

    protected $config;
    protected $fakerFactory;
    protected $order;
    protected $customer;
    protected $logger;
    protected $resolver;
    protected $customerRepositoryInterface;
    protected $orderPaymentInterface;
    protected $quote;
    protected $freePayment;
    protected $addressInterface;
    protected $storeManager;
    protected $cartManagementInterface;
    protected $cartRepositoryInterface;
    protected $productRepository;
    protected $orderRepository;

    public function __construct(
        \Faker\Factory $fakerFactory,
        \Magento\Sales\Model\Order $order,
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Locale\Resolver $resolver,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Sales\Api\Data\OrderPaymentInterface $orderPaymentInterface,
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\AddressInterface $addressInterface,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository)
    {
        $this->fakerFactory = $fakerFactory;
        $this->order = $order;
        $this->customer = $customer;
        $this->logger = $logger;
        $this->resolver = $resolver;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->orderPaymentInterface = $orderPaymentInterface;
        $this->quote = $quote;
        $this->addressInterface = $addressInterface;
        $this->storeManager = $storeManager;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function createOrderFromProductId($productId)
    {
        $this->logger->info($this->resolver->getLocale());

        $generator = $this->fakerFactory->create($this->resolver->getLocale());

        $firstName = $generator->firstName;
        $lastName = $generator->lastName;

        $customer = $this->customer
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($generator->email);
        try{
            /** @var \Magento\Customer\Api\Data\CustomerInterface $customerInterface */
            $customerInterface = $this->customerRepositoryInterface->save($customer);
        }catch (\Exception $e){
            $this->logger->error($e);
        }

        $store = $this->storeManager->getStore(1);
        $this->storeManager->setCurrentStore($store);

        try{
            $cartId = $this->cartManagementInterface->createEmptyCart();
        }catch (\Exception $e){
            $this->logger->error($e);
        }

        $cartInterface = $this->cartRepositoryInterface->get($cartId);

        $cartInterface->addProduct($this->productRepository->getById($productId), 2);

        $cartInterface->assignCustomer($customerInterface);

        $cartInterface->setBillingAddress(
            $this->addressInterface
            ->setCity($generator->city)
            ->setStreet([$generator->streetAddress])
            ->setCountryId('FR')
            ->setFirstname($firstName)
            ->setLastname($lastName)
            ->setPostcode($generator->postcode)
            ->setTelephone($generator->phoneNumber)
        );

        $cartInterface->setShippingAddress(
            $this->addressInterface
                ->setCity($generator->city)
                ->setStreet([$generator->streetAddress])
                ->setCountryId('FR')
                ->setFirstname($firstName)
                ->setLastname($lastName)
                ->setPostcode($generator->postcode)
                ->setTelephone($generator->phoneNumber)
        );

        $cartInterface->getShippingAddress()
            ->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('flatrate_flatrate');

        $cartInterface->setPaymentMethod(\Magento\OfflinePayments\Model\Checkmo::PAYMENT_METHOD_CHECKMO_CODE);
        $cartInterface->setInventoryProcessed(false);
        $cartInterface->getPayment()->importData(['method' => \Magento\OfflinePayments\Model\Checkmo::PAYMENT_METHOD_CHECKMO_CODE]);
        $cartInterface->collectTotals();

        try{
            $cartInterface->save();
        }catch (\Exception $e){
            $this->logger->error($e);
        }

        $orderId = $this->cartManagementInterface->placeOrder($cartInterface->getId());

        $order = $this->orderRepository->get($orderId);

        $order->setState(\Magento\Sales\Model\Order::STATE_COMPLETE, true);
        $order->setStatus(\Magento\Sales\Model\Order::STATE_COMPLETE);


        try{
            $order->save();
        }catch (\Exception $e){
            $this->logger->error($e);
        }


    }
}