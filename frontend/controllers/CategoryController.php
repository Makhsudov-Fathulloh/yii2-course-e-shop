<?php

namespace frontend\controllers;

use common\components\AppController;
use common\models\Product;
use common\models\Category;
use yii\data\Pagination;
use yii\web\HttpException;

class CategoryController extends AppController
{
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

    public function actionView($id) // Способ 1 get($id)
    {
//        $id = \Yii::$app->request->get('id'); // Способ 2 get($id)

        $category = Category::findOne($id);
        if (empty($category))
            throw new HttpException(404, 'The requested "Category" was not found');

        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('E-SHOP | Pagination ' . $category->name, $category->keywords, $category->description);

        return $this->render('view', ['products'=>$products,'pages'=>$pages, 'category'=>$category]);
    }
}