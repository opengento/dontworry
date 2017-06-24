<?php

namespace Opengento\Dontworry\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * @version 1.0.0
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
    ModuleDataSetupInterface $setup,
            ModuleContextInterface $context
    )
    {

        unset($context);

        $installer = $setup;
        $installer->startSetup();

        $data = [
            [
                "id" => null,
                "sentence" => ""
            ]
        ];

        $installer->getConnection()->truncateTable($installer->getTable("opengento_dontworry_fengshui"));
        foreach ($data as $sentence) {
            $installer->getConnection()->insert($installer->getTable("opengento_dontworry_fengshui"), $sentence);
        }

        $installer->endSetup();
    }

}
