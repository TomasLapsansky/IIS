<?php

namespace App\Presenters;

use Nette\Application\UI;

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

        $cart_products = unserialize($_COOKIE['cart']);

        if($cart_products) {
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

    protected function createComponentCartCount() {

        $form = new UI\Form();
        $form->addInteger("count", "Count:")->setRequired();
        $form->addSubmit("addToCart", "Add to cart");
        $form->onSuccess[] = [$this, "cartCountSuccedeed"];

        return $form;
    }
}