<?php

namespace App\Presenters;

use Nette\Application\UI;


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

    protected function createComponentSummaryForm() {

        $form = new UI\Form();
        $form->addInteger("count", "Count:")->setRequired();
        $form->addHidden("id");
        $form->addSubmit("summary", "Proceed to summary");
        $form->onSuccess[] = [$this, "someSpecialFunction"];

        return $form;
    }

}