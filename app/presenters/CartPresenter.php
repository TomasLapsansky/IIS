<?php

namespace App\Presenters;

use Nette\Application\UI;


final class CartPresenter extends BasePresenter
{

    protected function startup()
    {
        parent::startup();

        if(!$this->user->isLoggedIn()) {
            $this->flashMessage("Musite byt prihlaseny");
            $this->redirect("Login:");
            return;
        }
    }

    public function renderDefault()
    {
        if (isset($_SESSION['cart'])) {
            $cart_products = $_SESSION['cart'];

            $template_products = [];

            foreach ($cart_products as $product) {
                $temp_product = $this->productService->getByIDActive($product['productId']);
                if ($temp_product) {
                    $template_products[$product['productId']] = array($temp_product, $product['quantity']);
                }
            }

            $this->template->products = $template_products;
        }

    }

    public function actionSummary()
    {
        if(isset($_SESSION['cart'])) {

            $cart_products = $_SESSION['cart'];

            $template_products = [];

            foreach ($cart_products as $product) {
                $temp_product = $this->productService->getByIDActive($product['productId']);
                if ($temp_product) {
                    $template_products[$product['productId']] = array($temp_product, $product['quantity']);
                }
            }

            $this->template->products = $template_products;
        }
    }

    protected function createComponentSummaryForm()
    {

        $form = new UI\Form();
        $form->addSubmit("summary", "Proceed to summary");
        $form->onSuccess[] = [$this, "sendToSummarySuccedeed"];

        return $form;
    }

    public function sendToSummarySuccedeed(UI\Form $form, $values)
    {
        /*$cart_products = unserialize($_COOKIE['cart']);

        $products_summary =[];

        foreach ($cart_products as $product => $count) {
            //$product = $this->productService->getByIDActive($product_id);
            if($product) {
                $prod_count =$form->getHttpData($form::DATA_LINE, '{$product_id}');
                $products_summary[$product_id] = array($product, $prod_count);
            }
        }

        $this->redirect("Cart:summary", $products_summary);*/

        // TODO

        $this->redirect("Cart:summary");
    }

    public function handleBuy() {
        if(isset($_SESSION['cart'])) {

            $cart_products = $_SESSION['cart'];

            $sys_user = $this->userService->getByID($this->user->getId());
            $new_order = $this->orderService->insert([
                'city' => $sys_user->city,
                'zip' => $sys_user->zip,
                'address' => $sys_user->address,
                'user_id' => $sys_user->id,
                'status' => 'waiting'
            ]);

            foreach ($cart_products as $product) {
                $this->orderDrugService->insert([
                    'count' => $product['quantity'],
                    'drug_id' => $product['productId'],
                    'order_id' => $new_order->id
                ]);
            }

            $this->flashMessage("Vasa objednavka bola uspesne spracovana", "info");
            unset($_SESSION['cart']);
            $this->redirect("Order:");
        }
    }

}