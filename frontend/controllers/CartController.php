<?php

namespace frontend\controllers;

use common\components\AppController;
use common\models\Order;
use common\models\OrderItems;
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
        $id = Yii::$app->request->get('id'); // product id sini olsami
        $qty = (int)Yii::$app->request->get('id'); // integerga tekshirib, product sonini oladi
        $qty = !$qty ? 1 : $qty; // product soni bolmasa 1 yozadi, bolmasa kelayotkan son

        $product = Product::findOne($id); // product ni oladi
        if (empty($product)) return false; // product borligini tekshiradi

        $session = Yii::$app->session;
        $session->open();

        $cart = new Cart();
        $cart->addToCart($product, $qty); // $product id ni oladi, $qty sonini oladi
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer); // ozini page ga qaytadi
        }

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

    public function actionDelItem()
    {
        $id = Yii::$app->request->get('id');

        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id); // recalc() перешот

        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;

        return $this->render('cart-modal', compact('session'));
    }

    public function actionView()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');

        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if ($order->save()) {
                $this->saveOrderItems($session['cart'], $order->id); // buyurtma muaffaqiyatli bolsa saveOrderItems() chaqiramiz
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер вскоре свяжется с Вами в ближайшее время.');

                //Отправка почты на админ
                Yii::$app->mailer->compose('order', ['session' => $session])
                    ->setFrom(['mr.makhsudov@gmail.com' => 'yii2.loc'])
                    ->setTo->params['adminEmail']
                    ->setSubject('Заказ')
//                    ->setTextBody('Текст сообщения')
                    ->send();

                //Отправка почты на
                Yii::$app->mailer->compose('order', ['session' => $session]) // compose() method send emil
                    ->setFrom(['mr.makhsudov@gmail.com' => 'yii2.loc']) // real projectda pochta config bilan bir xil bolishkere
                    ->setTo($order->email) // qayerga yuboramiz (user korsatkan email ga)
                    ->setSubject('Заказ')
//                    ->setTextBody('Текст сообщения')
                    ->send();

                $session->remove('cart'); // cart ni tozalash
                $session->remove('cart.qty'); // product sonini tozalash
                $session->remove('cart.sum'); // product summasini tozalash

                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error!', 'Ошибка.');
            }
        }

        return $this->render('view', compact('session', 'order'));
    }

    protected function saveOrderItems($items, $order_id) {
        foreach ($items as $id => $item) {
            $order_items = new OrderItems(); // ActivRecord class dan foydalanganimiz sababli, xar 1 product uchun yangi object oladi
            $order_items->order_id = $order_id; // buyurtma id si
            $order_items->product_id = $id; // product id si
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty'] * $item['price'];
            $order_items->save();
        }
    }
}