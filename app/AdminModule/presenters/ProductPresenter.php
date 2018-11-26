<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Drug;
use Nette;

final class ProductPresenter extends BasePresenter {

    /** @var Drug @inject */
    public $productService;

    public function actionDefault() {
        if ($this->productService->count() != 0) {
            $this->template->products = $this->productService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->product = $this->productService->getByID($id);
    }

}