<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Producer;
use Nette;

final class ProducerPresenter extends AdminBasePresenter {
    
    /** @var Producer @inject */
    public $producerService;

    public function actionDefault() {
        if ($this->producerService->count() != 0) {
            $this->template->producers = $this->producerService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->producer = $this->producerService->getByID($id);
        $this->template->products = $this->productService->getAll()->where('producer', $id);
    }



}