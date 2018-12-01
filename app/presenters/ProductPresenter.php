<?php

namespace App\Presenters;


final class ProductPresenter extends BasePresenter
{

    public function actionDefault() {

        $this->template->products = $this->productService->getAll();
    }

    public function actionDetail($id) {

        $this->template->id = $id;
        $this->template->product = $product = $this->productService->getByID($id);

        $this->template->producer = $this->producerService->getByID($product->producer);
    }

    public function handleAddToCart($id) {

        if(isset($_COOKIE['cart'])) {
            $cart_products = unserialize($_COOKIE['cart']);
        } else {
            setcookie('cart', '', time() + 60 * 100000, '/');
            //$cart_products = unserialize($_COOKIE['cart']);
        }

        if(isset($cart_products)) {
            $cart = $cart_products + [
                $id => 1
                ];
        } else {
            $cart = [
                $id => 1    //count
            ];
        }

        setcookie('cart', serialize($cart), time() + 60 * 100000, '/');
    }
}