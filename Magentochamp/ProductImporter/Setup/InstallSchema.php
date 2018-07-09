<?php
namespace Entrepids\Importer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $tableName = $installer->getTable('entrepids_if_products');
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'sku',
                    Table::TYPE_TEXT,
                    64,
                    [],
                    'Sku'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'name'
                )
                ->addColumn(
                    'product_online',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'product_online'
                )
                ->addColumn(
                    'product_websites',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'product_websites'
                )->addColumn(
                    'weight',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'weight'
                )
                ->addColumn(
                    'runId',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'runId'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'description'
                )
                ->addColumn(
                    'short_description',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'short_description'
                )
                ->addColumn(
                    'errors',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'errors'
                )
                ->setComment('Entrepids if products')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $tableName = $installer->getTable('entrepids_if_products_import');
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'sku',
                    Table::TYPE_TEXT,
                    64,
                    [],
                    'Sku'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'name'
                )
                ->addColumn(
                    'product_online',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'product_online'
                )
                ->addColumn(
                    'product_websites',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'product_websites'
                )->addColumn(
                    'weight',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'weight'
                )
                ->addColumn(
                    'price',
                    Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'price'
                )
                ->addColumn(
                    'runId',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'runId'
                )
                ->addColumn(
                    'product_type',
                    Table::TYPE_TEXT,
                    64,
                    [],
                    'product_type'
                )
                ->addColumn(
                    'attribute_set_code',
                    Table::TYPE_TEXT,
                    64,
                    [],
                    'attribute_set_code'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'description'
                )
                ->addColumn(
                    'short_description',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'short_description'
                )
                ->addColumn(
                    'errors',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'errors'
                )
                ->setComment('entrepids_if_products_import')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}