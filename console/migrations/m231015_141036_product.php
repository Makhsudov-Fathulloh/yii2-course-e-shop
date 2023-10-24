<?php

use yii\db\Migration;

/**
 * Class m231015_141036_product
 */
class m231015_141036_product extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(512),
            'content' => $this->text()->notNull(),
            'price' => $this->float()->defaultValue(0),
            'keywords' => $this->string(512)->notNull(),
            'description' => $this->string(512)->notNull(),
            'images' => $this->string(512)->notNull()->defaultValue('no-image.png'),
            'hit' => $this->integer()->defaultValue(0), // enum(2, 3)->defaultValue(0),
            'new' => $this->integer()->defaultValue(0), // enum(2, 3)->defaultValue(0),
            'sale' => $this->integer()->defaultValue(0), // enum(2, 3)->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            ]);

        $this->createIndex(
            'idx-product-category_id',
            '{{%product}}',
            'category_id'
        );

        $this->addForeignKey(
            'fk-product-category_id-category-id',
            '{{%product}}',
            'category_id',
            '{{%category}}',
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
            'fk-product-category_id-category-id',
            '{{%product}}',
        );

        $this->dropIndex(
            'idx-product-category_id',
            '{{%product}}',
        );

        $this->dropTable('{{%product}}');

    }
}
