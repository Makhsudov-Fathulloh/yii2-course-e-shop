<?php

namespace frontend\controllers;

use common\components\AppController;
use common\models\Product;
use yii\data\Pagination;

class SearchController extends AppController
{
    public function actionSearch()
    {
//        $q = \Yii::$app->request->get('q');
        $q = trim(\Yii::$app->request->get('q')); // без строка и пробел
        $this->setMeta('E-SHOP | Search: ' . $q);
        if (!$q)
            return $this->render('search');

        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('search', compact('products', 'pages', 'q'));
    }
}