<?php
namespace Magentochamp\Complaint\Setup;

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

        $tableName = $installer->getTable('magentochamp_complaint');
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
                    'name',
                    Table::TYPE_TEXT,
                    225,
                    [],
                    'Name'
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'email'
                )
                ->addColumn(
                    'reason',
                    Table::TYPE_INTEGER,
                    11,
                    [],
                    'Reason'
                )
                ->addColumn(
                    'mobno',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Contact No'
                )
                ->addColumn(
                    'uploadfile',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Upload File'
                )
                ->addColumn(
                    'comments',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Comments'
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
                ->setComment('Magentochamp Complaint Feedback')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $tableName = $installer->getTable('magentochamp_ordercomplaint');
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
                    'orderid',
                    Table::TYPE_TEXT,
                    225,
                    [],
                    'OrderId'
                )
                ->addColumn(
                    'uploadfile',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Upload File'
                )
                ->addColumn(
                    'comments',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Comments'
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
                ->setComment('Magentochamp Complaint Feedback')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}