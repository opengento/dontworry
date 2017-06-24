<?php

namespace Opengento\Dontworry\Plugin\Message;
use Magento\Framework\Message\MessageInterface;

class Factory
{
    public function beforeCreate($interceptor, $type, $text = null)
    {
        $type = MessageInterface::TYPE_SUCCESS;
        $text = sprintf(__('Bravo! %s'), $text);

        return [$type, $text];
    }
}