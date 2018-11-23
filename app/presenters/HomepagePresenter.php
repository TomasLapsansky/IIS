<?php

namespace App\Presenters;

final class HomepagePresenter extends BasePresenter
{

    public function actionDefault() {
        $this->template->test = "IIS main page";
    }

}
