<?php

namespace App\Presenters;


final class CartPresenter extends BasePresenter {

    public function renderDefault() {
        $cart_products = unserialize($_COOKIE['cart']);

        $template_products = [];

        foreach ($cart_products as $product_id => $count) {
            $product = $this->productService->getByID($product_id);
            $template_products[$product_id] = array($product, $count);
        }

        $this->template->products = $template_products;
    }

}