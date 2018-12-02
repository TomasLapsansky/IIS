<?php

namespace App\Presenters;

use Nette\Application\UI;


final class CartPresenter extends BasePresenter {

    public function renderDefault() {
        $cart_products = unserialize($_COOKIE['cart']);

        $template_products = [];

        foreach ($cart_products as $product_id => $count) {
            $product = $this->productService->getByIDActive($product_id);
            if($product) {
                $template_products[$product_id] = array($product, $count);
            }
        }

        $this->template->products = $template_products;
    }

    protected function createComponentSummaryForm() {

        $form = new UI\Form();
        $form->addSubmit("summary", "Proceed to summary");
        $form->onSuccess[] = [$this, "sendToSummarySuccedeed"];

        return $form;
    }

    public function sendToSummarySuccedeed(UI\Form $form, $values) {
        $cart_products = unserialize($_COOKIE['cart']);

        $products_summary =[];

        foreach ($cart_products as $product_id => $count) {
            $product = $this->productService->getByIDActive($product_id);
            if($product) {
                $prod_count =$form->getHttpData($form::DATA_LINE, '{$product_id}');
                $products_summary[$product_id] = array($product, $prod_count);
            }
        }

        $this->template->products = $products_summary;
    }

}