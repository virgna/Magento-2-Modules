<?php

namespace Magentochamp\Interior\Setup;

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

        $tableName = $installer->getTable('magentochamp_interior');
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
                    'firmname',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Firm Nam'
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Email'
                )
                ->addColumn(
                    'mobno',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Mobile Number'
                )
                ->addColumn(
                    'pincode',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Pincode'
                )
                ->addColumn(
                    'city',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'City'
                )
                ->addColumn(
                    'speciality',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'Speciality'
                )
                ->addColumn(
                    'experience',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Experience'
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
                ->setComment('Magentochamp Interior')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}