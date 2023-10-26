<?php

namespace frontend\controllers;

use common\components\AppController;
use common\models\Product;
use yii\web\HttpException;
use Yii;

class ProductController extends AppController
{
    public function actionView($id) // Способ 1 get($id)
    {
//        $id = Yii::$app->request->get('id'); // Способ 2 get($id)
        $product = Product::findOne($id);
        if (empty($product))
            throw new HttpException(404, 'The requested "Product" was not found');
//        $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();

        $hits = Product::find()->where(['hit'=>'1'])->limit(10)->all();
        $this->setMeta('E-SHOP | Pagination ' . $product->name, $product->keywords, $product->description);

        return $this->render('view', compact('product', 'hits'));
    }
}