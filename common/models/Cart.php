<?php

namespace common\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function addToCart($product, $qty=1) // $qty=1 default holatda 1ta tovar qoshish
    {
        if (isset($_SESSION['cart'][$product->id])) { // agar cart da product bolsa unga userdan kelayotkanini qoshadi
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {                                      // yoq bolsa yangisini yaratadi
            $_SESSION['cart'][$product->id] = [
              'qty' => $qty,
              'name' => $product->name,
              'price' => $product->price,
              'images' => $product->images
            ];
        }
            // agar cart da product bolsa unga userdan kelayotkan productni qoshadi, yoq bolsa userdan kelayotkan yangisini yaratadi
            $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;

            // agar cart da product summasi bolsa unga userdan kelayotkan summani qoshadi, yoq bolsa userdan kelayotkan yangisini yaratadi
            $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }

    public function recalc($id)
    {
        if(!isset($_SESSION['cart'][$id])) return false; // cartka qoshayotkan productni tekshiradi

        $qtyMinus = $_SESSION['cart'][$id]['qty']; // delete qilinayotkan mahsulotni olish
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];  // delete qilinayotkan mahsulotni price ni olish
        $_SESSION['cart.qty'] -= $qtyMinus; // cart dan delete qilinayotkan mahsulotni sonini ayrish
        $_SESSION['cart.sum'] -= $sumMinus; // cart dan delete qilinayotkan mahsulotni narhini ayrish

        unset($_SESSION['cart'][$id]); // cart dan delete qilinayotkan mahsulotni ochirish
    }

    // product delete, login cart
}