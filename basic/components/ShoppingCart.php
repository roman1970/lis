<?php
namespace app\components;

use yii\web\Session;

class ShoppingCart {

    public function Add($id) {
        $session = new Session();
        $session->open();

        $cart = $session->get('cart', []);
        if(empty($cart[$id])) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }
    }


}