<?php

namespace common\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function getCategory()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id']);
    }
}
