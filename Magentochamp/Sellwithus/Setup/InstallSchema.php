<?php

namespace Magentochamp\Sellwithus\Setup;

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

        $tableName = $installer->getTable('magentochamp_sellwithus');
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
                    'firstname',
                    Table::TYPE_TEXT,
                    225,
                    [],
                    'First Name'
                )
                ->addColumn(
                    'lastname',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Last Name'
                )
                ->addColumn(
                    'companyname',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Company Name'
                )
                ->addColumn(
                    'companytype',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'Company Name'
                )
                ->addColumn(
                    'address',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Address'
                )
                ->addColumn(
                    'city',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'City'
                )
                ->addColumn(
                    'state',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'State'
                )
                ->addColumn(
                    'pincode',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Pincode'
                )
                ->addColumn(
                    'mobno',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Contact No'
                )
                ->addColumn(
                    'category',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'Category'
                )
                
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'email'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_DATETIME,
                    null,
                    [],
                    'Updated At'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->setComment('Magentochamp Sellwithus')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}