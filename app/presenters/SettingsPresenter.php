<?php

namespace App\Presenters;
use Nette\Application\UI;


final class SettingsPresenter extends BasePresenter {

    public function actionDefault() {

    }

    protected function createComponentSetUser()
    {
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form();
        $form->addText('name', 'Name:')->setRequired();
        $form->addText('surname', 'Surname:')->setRequired();
        $form->addPassword('pass', 'Password:')->setRequired();
        $form->addText('city', 'City:')->setRequired();
        $form->addText('address', 'Address:')->setRequired();
        $form->addText('zip', 'ZIP:')->setRequired();
        $form->addText('country', 'Country:')->setRequired();
        $form->addSelect('insurer', 'Poistovna:', $insurers->fetchPairs('id', 'name'))->setRequired();
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

}