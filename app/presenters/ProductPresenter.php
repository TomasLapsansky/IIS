<?php

namespace App\Presenters;

use Nette\Application\UI;

final class ProductPresenter extends BasePresenter
{

    public function renderDefault() {

        $this->template->products = $this->productService->getAllActive();
    }

    public function renderDetail($id) {

        $this->template->id = $id;
        $this->template->product = $product = $this->productService->getByIDActive($id);

        if($product) {
            $this->template->producer = $this->producerService->getByID($product->producer);

            $this['cartCount']->setDefaults([
                'id' => $id,
                'count' => 1
            ]);
        }
    }

    public function cartCountSucceeded(UI\Form $form, $values) {

        if(!$this->user->isLoggedIn()) {
            $this->flashMessage("Musite byt prihlaseny");
            $this->redirect("Login:");
            return;
        }

        if($values->count > 0) {

            /*if (isset($_COOKIE['cart'])) {
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

            setcookie('cart', serialize($cart), time() + 60 * 100000, '/');*/

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            //if(isset($_SESSION['cart'][]))
            $bag = array(
                "productId" => $values->id,
                "quantity"  => $values->count
            );
            $_SESSION['cart'][] = $bag;

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