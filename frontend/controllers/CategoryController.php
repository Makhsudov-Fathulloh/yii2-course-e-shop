<?php

namespace frontend\controllers;

use common\components\ApiController;
use common\models\Product;
use common\models\Category;
use yii\data\Pagination;

class CategoryController extends ApiController
{
    /**
     * @var mixed
     */
    public $name;
    public $keywords;
    public $description;

    public function actionIndex() {
//        $hits = Product::find()->where(['hit'=>'1'])->limit(10)->all();
        $hits = Product::find()->all();
        $this->setMeta('E-SHOP');
        return $this->render('index', compact('hits'));
    }

//    public function actionView($id)
//    {
//        $id = \Yii::$app->request->get('id');
//        $products = Product::find()->where(['category_id' => $id])->all();
//        return $this->render('view', compact('products'));
//    }

    public function actionView($id)
    {
        $id = \Yii::$app->request->get('id');
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $category = Category::findOne($id);
        $this->setMeta('E-SHOP | Pagination ' . $category->name, $category->keywords, $category->description);

        return $this->render('view', compact('products','pages', 'category'));
    }
}