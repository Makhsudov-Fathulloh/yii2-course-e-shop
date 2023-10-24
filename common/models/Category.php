<?php

namespace common\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * @var mixed|null
     */
    public $name;
    public $keywords;
    public $description;

    public static function tableName()
    {
        return '{{%category}}';
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }
}
