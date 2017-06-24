<?php

namespace Opengento\Dontworry\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    
    /**
     * @version 1.0.0
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        unset($context);
        
        $installer = $setup;

        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable('opengento_dontworry_fengshui'));

        $fengshui = $installer->getConnection()
                ->newTable($installer->getTable('opengento_dontworry_fengshui'))
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    11,
                    [ 'identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Item ID'
                )
                ->addColumn(
                    'sentence',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    5000,
                    [ 'identity' => false, 'unsigned' => true, 'nullable' => false, 'primary' => false],
                    'Sentence'
                )
                ->setComment('Fengshui sentences');

        $installer->getConnection()->createTable($fengshui);

        $installer->endSetup();
    }
}
