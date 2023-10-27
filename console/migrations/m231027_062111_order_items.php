<?php

use yii\db\Migration;

/**
 * Class m231027_062111_order_items
 */
class m231027_062111_order_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_items}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'name' => $this->string(512),
            'price' => $this->float(),
            'qty_item' => $this->integer(),
            'sum_item' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-order_items-order_id',
            '{{%order_items}}',
            'order_id'
        );

        $this->addForeignKey(
            'fk-order_items-order_id-order-id',
            '{{%order_items}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-order_items-product_id',
            '{{%order_items}}',
            'product_id'
        );

        $this->addForeignKey(
            'fk-order_items-product_id-product-id',
            '{{%order_items}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-order_items-order_id-order-id',
            '{{%order_items}}',
        );

        $this->dropIndex(
            'idx-order_items-order_id',
            '{{%order_items}}',
        );

        $this->dropForeignKey(
            'fk-order_items-product_id-product-id',
            '{{%order_items}}',
        );

        $this->dropIndex(
            'idx-order_items-product_id',
            '{{%order_items}}',
        );

        $this->dropTable('{{%order_items}}');

    }
}
