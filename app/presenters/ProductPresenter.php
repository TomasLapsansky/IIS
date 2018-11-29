<?php

namespace App\Presenters;


final class ProductPresenter extends BasePresenter {

    public function actionDefault() {
        $this->template->products = $this->productService->getAll();
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->product = $this->productService->getByID($id);
    }
}