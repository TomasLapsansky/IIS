<?php

namespace App\Presenters;


final class OrderPresenter extends BasePresenter {

    protected function startup()
    {
        parent::startup();

        if(!$this->user->isLoggedIn()) {
            $this->redirect("Login:");
        }
    }

    public function renderDefault() {
        $this->template->orders = $this->orderService->getAllActive()->where('user_id', $this->user->getId());
        $this->template->orderDrugService = $this->orderDrugService;
    }

    public function actionDetail() {

    }

}