<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Order;
use Nette;

final class OrderPresenter extends BasePresenter {

    /** @var Order @inject */
    public $orderService;

    public function actionDefault() {
        if ($this->orderService->count() != 0) {
            $this->template->orders = $this->orderService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->order = $this->orderService->getByID($id);
    }

    public function actionAdd() {
        
    }

    public function actionEdit($id) {
        $this->template->order = $this->orderService->getByID($id);
    }

}