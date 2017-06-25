<?php

namespace Opengento\Dontworry\Plugin\Newsletter\Controller\Adminhtml\Subscriber;

class MassUnsubscribeDelete  extends \Magento\Newsletter\Controller\Adminhtml\Subscriber
{

    public function execute() {
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
        $this->messageManager->addSuccess(__('No customers have be removed!'));
        $this->_redirect('*/*/index');
    }

}
