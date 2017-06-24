<?php

namespace Opengento\Dontworry\Helper;

class Data  extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    public $scopeConfig = null;

    public function __construct(
    \Magento\Framework\App\Helper\Context $context
    )
    {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
    }
    
    public function getRandomSentence()
    {
        $sentences = $this->scopeConfig->getValue("dontworry/befengshui/sentences", \Magento\Store\Model\ScopeInterface::SCOPE_STORE, 0);
        $sentences = explode("\n",$sentences);
        return $sentences[rand(0, count($sentences)-1)];
    }
    
}
