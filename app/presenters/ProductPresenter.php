<?php

namespace App\Presenters;

use Nette\Application\UI;

final class ProductPresenter extends BasePresenter
{

    public function renderDefault() {

        $this->template->products = $this->productService->getAll();
    }

    public function renderDetail($id) {

        $this->template->id = $id;
        $this->template->product = $product = $this->productService->getByID($id);

        $this->template->producer = $this->producerService->getByID($product->producer);

        $this['cartCount']->setDefaults([
            'id' => $id,
            'count' => 1
        ]);
    }

    public function cartCountSucceeded(UI\Form $form, $values) {

        if($values->count > 0) {

            if (isset($_COOKIE['cart'])) {
                $cart_products = unserialize($_COOKIE['cart']);
            } else {
                setcookie('cart', '', time() + 60 * 100000, '/');
                //$cart_products = unserialize($_COOKIE['cart']);
            }

            if (isset($cart_products)) {
                $cart = $cart_products + [
                        $values->id => $values->count
                    ];
            } else {
                $cart = [
                    $values->id => $values->count    //count
                ];
            }

            setcookie('cart', serialize($cart), time() + 60 * 100000, '/');
        } else {
            $this->flashMessage("Mnozstvo musi byt aspon 1", "warning");
            return;
        }
    }

    protected function createComponentCartCount() {

        $form = new UI\Form();
        $form->addInteger("count", "Count:")->setRequired();
        $form->addHidden("id");
        $form->addSubmit("addToCart", "Add to cart");
        $form->onSuccess[] = [$this, "cartCountSucceeded"];

        return $form;
    }
}