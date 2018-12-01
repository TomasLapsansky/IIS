<?php

namespace App\Presenters;
use Nette\Application\UI;


final class SettingsPresenter extends BasePresenter {

    protected function startUp() {

        parent::startup();

        if(!$this->user->isLoggedIn()) {
            $this->redirect(":Login:");
        }

    }

    public function actionDefault() {

        $this->template->sys_user = $sys_user = $this->userService->getByID($this->user->getIdentity()->getId());

        $this['setUser']->setDefaults([
            'name' => $sys_user->name,
            'surname' => $sys_user->surname,
            'city' => $sys_user->city,
            'address' => $sys_user->address,
            'zip' => $sys_user->zip,
            'country' => $sys_user->country,
            'insurer' => $sys_user->insurer_id
        ]);

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
        $form->onSuccess[] = [$this, 'setUserSucceeded'];
        return $form;
    }

}