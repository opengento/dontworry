<?php
namespace Opengento\Dontworry\Model;

use Magento\Cron\Exception;
use Magento\Framework\App\TemplateTypesInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class Transport extends TransportBuilder
{

    protected function prepareMessage()
    {
        $template = $this->getTemplate();
        $types = [
            TemplateTypesInterface::TYPE_TEXT => MessageInterface::TYPE_TEXT,
            TemplateTypesInterface::TYPE_HTML => MessageInterface::TYPE_HTML,
        ];

        $body = $template->processTemplate();
        $this->message->setMessageType($types[$template->getType()])
            ->setBody($body)
            ->setSubject(__('Don\'t worry !') . ' ' . $template->getSubject());

        return $this;
    }

}