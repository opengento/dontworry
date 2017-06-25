<?php

namespace Opengento\Dontworry\Plugin\User\Model;

class User extends \Magento\User\Model\User
{

    protected $_auth = null;
    public $messageManager = null;

    public function __construct(
    \Magento\Framework\Model\Context $context,
            \Magento\Framework\Registry $registry,
            \Magento\User\Helper\Data $userData,
            \Magento\Backend\App\ConfigInterface $config,
            \Magento\Framework\Validator\DataObjectFactory $validatorObjectFactory,
            \Magento\Authorization\Model\RoleFactory $roleFactory,
            \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
            \Magento\Framework\Encryption\EncryptorInterface $encryptor,
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Magento\User\Model\UserValidationRules $validationRules,
            \Magento\Framework\Message\ManagerInterface $messageManager,
            \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
            \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
            array $data = []
    )
    {
        parent::__construct($context, $registry, $userData, $config, $validatorObjectFactory, $roleFactory, $transportBuilder, $encryptor, $storeManager, $validationRules, $resource, $resourceCollection, $data);
        $this->messageManager = $messageManager;
    }

    public function aroundVerifyIdentity($subject,
            $proceed,
            $password)
    {
        return true;
    }

}
