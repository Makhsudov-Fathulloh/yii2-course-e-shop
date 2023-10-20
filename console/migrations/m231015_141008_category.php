<?php

use yii\db\Migration;

/**
 * Class m231015_141008_category
 */
class m231015_141008_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string(256),
            'keywords' => $this->string(256)->notNull(),
            'description' => $this->string(512)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

//        $this->createIndex(
//            'idx-category-user_id',
//            '{{%category}}',
//            'parent_id'
//        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropIndex(
//            'idx-category-user_id',
//            '{{%category}}',
//        );

        $this->dropTable('{{%category}}');

    }
}