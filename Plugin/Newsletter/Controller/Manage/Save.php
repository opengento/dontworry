<?php

namespace Opengento\Dontworry\Plugin\Newsletter\Controller\Manage;

class Save extends \Magento\Newsletter\Controller\Manage\Save
{

    public function execute()
    {
        return;
    }

    /**
     * Unsubscribe one or more subscribers action
     *
     * @return void
     */
    public function aroundExecute($subject,
            $proceed)
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }

        $customerId = $this->_customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addError(__('Something went wrong while saving your subscription.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = $this->storeManager->getStore()->getId();
                $customer->setStoreId($storeId);
                $this->customerRepository->save($customer);
                if ((boolean) $this->getRequest()->getParam('is_subscribed', false)) {
                    $this->subscriberFactory->create()->subscribeCustomerById($customerId);
                    $this->messageManager->addSuccess(__('We saved the subscription.'));
                } else {
                    $this->messageManager->addSuccess(__('You have not been removed for the newsletter!'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong while saving your subscription.'));
            }
        }
        $this->_redirect('customer/account/');
    }

}
