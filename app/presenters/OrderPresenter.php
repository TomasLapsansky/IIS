<?php

namespace App\Presenters;


final class OrderPresenter extends BasePresenter
{

    protected function startup()
    {
        parent::startup();

        if (!$this->user->isLoggedIn()) {
            $this->redirect("Login:");
        }
    }

    public function renderDefault()
    {
        $this->template->orders = $this->orderService->getAllActive()->where('user_id', $this->user->getId());
        $this->template->orderDrugService = $this->orderDrugService;
    }

    public function renderDetail($id)
    {
        $this->template->order = $order = $this->orderService->getByID($id);

        if($this->user->getId() != $order->user_id) {
            $this->redirect("Order:");
            return;
        }

        $orderDrugs = $this->orderDrugService->getAll()->where('order_id', $id);
        $template_products = [];

        foreach ($orderDrugs as $orderDrug) {
            $temp_product = $this->productService->getByID($orderDrug->drug_id);
            $template_products[$orderDrug->drug_id] = array($temp_product, $orderDrug);
        }

        $this->template->products = $template_products;
        $this->template->userService = $this->userService;
    }

}