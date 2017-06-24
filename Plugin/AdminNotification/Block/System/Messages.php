<?php

namespace Opengento\Dontworry\Plugin\AdminNotification\Block\System;

class Messages
{

    protected $_messages;

    public $helper = null;
    
    public function __construct(
        \Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\Synchronized $messages,
            \Opengento\Dontworry\Helper\Data $helper
    ) {
        $this->_messages = $messages;
        $this->helper = $helper;
    }
    
    public function aroundGetLastCritical($subject,
            $proceed)
    {
        $items = array_values($this->_messages->getItems());
        if (isset(
                        $items[0]
                ) && $items[0]->getSeverity() == \Magento\Framework\Notification\MessageInterface::SEVERITY_CRITICAL
        ) {
            $items[0]->setText($this->helper->getRandomSentence());
            return $items[0];
        }
        return null;
    }

}
