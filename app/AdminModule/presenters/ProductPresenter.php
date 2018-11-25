<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Nette;

final class ProductPresenter extends BasePresenter {

    public function actionDefault() {

    }

    public function actionDetail($id) {
        $this->template->id = $id;
    }

}