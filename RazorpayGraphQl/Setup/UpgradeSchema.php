<?php

namespace Razorpay\RazorpayGraphQl\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Razorpay\Magento\Model\ResourceModel\OrderLink;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.1') < 0) {
            $tableName  = $setup->getTable(OrderLink::TABLE_NAME);
            $connection = $setup->getConnection();

            if ($connection->isTableExists($tableName) == true) {
                $connection->addColumn($tableName, 'rzp_signature', [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 200,
                    'nullable' => true,
                    'default'  => '',
                    'comment'  => __('Razorpay Signature'),
                    'after'    => 'rzp_payment_id',
                ]);
            }
        }
        $setup->endSetup();
    }
}
