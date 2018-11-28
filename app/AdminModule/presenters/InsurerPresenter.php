<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Insurer;
use Nette;

final class InsurerPresenter extends AdminBasePresenter {

    /** @var Insurer @inject */
    public $insurerService;

    public function actionDefault() {
        if ($this->insurerService->count() != 0) {
            $this->template->insurers = $this->insurerService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->insurer = $this->insurerService->getByID($id);
    }

    public function actionAdd() {
        
    }

    public function actionEdit($id) {
        $this->template->insurer = $this->insurerService->getByID($id);
    }

}