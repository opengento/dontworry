<?php

namespace Opengento\Dontworry\Model;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\ObserverInterface;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\ResourceModel\Rating\Collection;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;
use Opengento\Dontworry\Helper\Data as DataHelper;

class Observer implements ObserverInterface
{
    protected $reviewFactory;
    protected $productRepository;
    protected $ratingsCollectionFactory;
    protected $ratingFactory;
    protected $dataHelper;

    /**
     * @param ReviewFactory $reviewFactory
     * @param ProductRepository $productRepository
     * @param Collection $ratingCollectionFactory
     * @param RatingFactory $ratingFactory
     * @param DataHelper $dataHelper
     */
    public function __construct(
        ReviewFactory $reviewFactory,
        ProductRepository $productRepository,
        Collection $ratingCollectionFactory,
        RatingFactory $ratingFactory,
        DataHelper $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->productRepository = $productRepository;
        $this->reviewFactory = $reviewFactory;
        $this->ratingsCollectionFactory = $ratingCollectionFactory;
        $this->ratingFactory = $ratingFactory;
    }

    /**
     * fires when sales_order_save_after is dispatched
     *
     * @param Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        foreach($order->getAllVisibleItems() as $item)
        {
            $productId = $item->getProductId();
            $this->_createReview($productId, $order);
        }

        //TODO : Message manager
        //$this->messageManager->addSuccess(__('Thank you for all your very nice 5 stars reviews!'));
    }

    /**
     * Create review for given product ID and order
     */
    protected function _createReview($productId, $order)
    {
        $review = $this->reviewFactory->create();
        $product = $this->productRepository->getById($productId);

        //Set review
        $sentence = $this->dataHelper->getRandomSentence();
        $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
            ->setEntityPkValue($productId)
            ->setStatusId(Review::STATUS_APPROVED)
            ->setCustomerId($order->getCustomerId())
            ->setStoreId($order->getStoreId())
            ->setStores([$order->getStoreId()])
            ->setTitle(substr($sentence, 0, strpos($sentence, ' ', 30)).'...')
            ->setNickname($order->getCustomerFirstname() . ' ' . $order->getCustomerLastname())
            ->setDetail($sentence)
            ->save();

        //Add rates for all ratings
        $ratings = $this->ratingsCollectionFactory;

        foreach ($ratings as $rating) {
            //Get best option for current rate
            $lastValue = 0;
            $options = $rating->getOptions();
            $optionId = null;
            $lastOptionId = null;

            foreach($options as $option)
            {
                if($option->getValue() > $lastValue)
                {
                    $lastOptionId = $optionId;
                    $optionId = $option->getId();
                }
            }

            //Random option ID between rate 4 and 5
            $optionId = ($lastOptionId && rand(1, 2) < 2)?$lastOptionId:$optionId;

            if($optionId)
            {
                $this->ratingFactory->create()
                    ->setRatingId($rating->getId())
                    ->setReviewId($review->getId())
                    ->setCustomerId($order->getCustomerId())
                    ->addOptionVote($optionId, $product->getId());
            }
        }

        $review->aggregate();
    }
}
