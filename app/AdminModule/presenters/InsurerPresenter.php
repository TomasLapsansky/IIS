<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Insurer;
use Nette;

final class InsurerPresenter extends BasePresenter {

    /** @var Insurer @inject */
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

    public function actionAdd() {
        
    }

    public function actionEdit($id) {
        $this->template->product = $this->productService->getByID($id);
    }

}