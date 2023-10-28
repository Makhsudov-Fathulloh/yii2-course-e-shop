<?php

use yii\db\Migration;

class m130524_201442_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(64),
            'last_name' => $this->string(64),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(512),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'role' => $this->integer()->defaultValue(3),

            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'first_name' => "admin",
            'last_name' => "admin",
            'username' => "admin",
            'role' => 2,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin12345'),
            'password_reset_token' => Yii::$app->security->generateRandomString(),
            'email' => 'admin@gmail.com',

            'status' => \common\models\User::STATUS_ACTIVE,
            'created_at' => date('U'),
            'updated_at' => date('U'),
        ]);

        $this->insert('{{%user}}', [
            'first_name' => "user",
            'last_name' => "client",
            'username' => "user",
            'role' => 3,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('user12345'),
            'password_reset_token' => Yii::$app->security->generateRandomString(),
            'email' => 'user@gmail.com',

            'status' => \common\models\User::STATUS_ACTIVE,
            'created_at' => date('U'),
            'updated_at' => date('U'),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
