<?php

namespace App\Presenters;


final class ProductPresenter extends BasePresenter {

    public function actionDefault() {
        $this->template->products = $this->productService->getAll();
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->product = $product = $this->productService->getByID($id);

        $this->template->producer = $this->producerService->getByID($product->producer);
    }
}