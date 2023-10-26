<?php

namespace frontend\controllers;

use common\components\AppController;
use common\models\Product;
use common\models\Cart;
use Yii;

/*Array
(
    [1] => Array
    (
    [qty] => QTY
    [name] => NAME
    [price] => PRICE
    [images] => IMAGES
    )
    [10] => Array
(
    [qty] => QTY
    [name] => NAME
    [price] => PRICE
    [images] => IMAGES
    )
    [qty] => QTY
    [sum] => SUM
);*/
class CartController extends AppController
{
    public function actionAdd()
    {
        $id = Yii::$app->request->get('id');

        $product = Product::findOne($id);
        if (empty($product)) return false;

        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product);

//        debug($session['cart']);
//        debug($session['cart.qty']);
//        debug($session['cart.sum']);

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
}