<?php

use yii\db\Migration;

/**
 * Class m231027_062026_order
 */
class m231027_062026_order extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
            'email' => $this->string(256),
            'phone' => $this->string(256),
            'address' => $this->string(256),
            'qty' => $this->integer(),
            'sum' => $this->float(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
