<?php

namespace frontend\controllers;

use common\components\ApiController;
use common\models\Product;
use common\models\Category;

class CategoryController extends ApiController
{
    public function actionIndex() {
        $hits = Product::find()->where(['hit' => 1])->limit(6)->all();
        return $this->render('index', compact('hits'));
    }
}