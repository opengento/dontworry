<?php

namespace Opengento\Dontworry\Plugin\AdminNotification\Controller\Adminhtml\System\Message;

class ListAction
{

    public $jsonHelper = null;
    public $messageCollection = null;
    public $request = null;
    public $response = null;
    public $helper = null;

    public function __construct(
    \Magento\Framework\Json\Helper\Data $jsonHelper,
            \Magento\AdminNotification\Model\ResourceModel\System\Message\Collection $messageCollection,
            \Magento\Framework\App\RequestInterface $request,
            \Magento\Framework\App\Response\Http $response,
            \Opengento\Dontworry\Helper\Data $helper
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->messageCollection = $messageCollection;
        $this->request = $request;
        $this->response = $response;

        $this->helper = $helper;
    }

    public function aroundExecute($subject,
            $proceed)
    {
        $severity = $this->request->getParam('severity');
        if ($severity) {
            $this->messageCollection->setSeverity($severity);
        }
        $result = [];
        foreach ($this->messageCollection->getItems() as $item) {
            $result[] = [
                'severity' => (string) \Magento\Framework\Notification\MessageInterface::SEVERITY_NOTICE,
                'text' => $this->helper->getRandomSentence(),
            ];
        }
        if (empty($result)) {
            $result[] = [
                'severity' => (string) \Magento\Framework\Notification\MessageInterface::SEVERITY_NOTICE,
                'text' => 'You have viewed and resolved all recent system notices. '
                . 'Please refresh the web page to clear the notice alert.',
            ];
        }
        $this->response->representJson($this->jsonHelper->jsonEncode($result));
    }

}
