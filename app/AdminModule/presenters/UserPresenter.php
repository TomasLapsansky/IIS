<?php

namespace App\AdminModule\Presenters;


use App\Presenters\BasePresenter;
use Models\User;

final class UserPresenter extends BasePresenter {

    /** @var User @inject */
    public $userService;

    public function actionDefault() {
        if ($this->userService->count() != 0) {
            $this->template->users = $this->userService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->sys_user = $this->userService->getByID($id);
    }

    public function actionAdd() {
        
    }

    public function actionEdit() {
        
    }

}