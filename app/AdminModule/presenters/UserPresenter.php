<?php

namespace App\AdminModule\Presenters;


use App\Presenters\BasePresenter;

final class UserPresenter extends BasePresenter {

    public function actionDefault() {

    }

    public function actionDetail($id) {
        $this->template->id = $id;
    }

}