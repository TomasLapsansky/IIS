<?php

namespace App\Presenters;
use Nette\Application\UI;
use Nette\Security\Passwords;


final class SettingsPresenter extends BasePresenter {

    protected function startUp() {

        parent::startup();

        if(!$this->user->isLoggedIn()) {
            $this->flashMessage("Je potrebne sa prihlasit", "warn");
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
            'insurer' => $sys_user->insurer_id,
            'id' => $sys_user->id
        ]);

    }

    protected function createComponentSetUser()
    {
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form();
        $form->addText('name', 'Name:')->setRequired();
        $form->addText('surname', 'Surname:')->setRequired();
        $form->addPassword('password', 'Password:');
        $form->addText('city', 'City:')->setRequired();
        $form->addText('address', 'Address:')->setRequired();
        $form->addText('zip', 'ZIP:')->setRequired();
        $form->addText('country', 'Country:')->setRequired();
        $form->addHidden('id');
        $form->addSelect('insurer', 'Poistovna:', $insurers->fetchPairs('id', 'name'))->setRequired();
        $form->addSubmit('edit', 'Edit');
        $form->onSuccess[] = [$this, 'setUserSucceeded'];
        return $form;
    }

    public function setUserSucceeded(UI\Form $form, $values) {

        $sys_user = $this->userService->getByID($values->id);

        $sys_user->update([
            'name' => $values->name,
            'surname' => $values->surname,
            'city' => $values->city,
            'address' => $values->address,
            'zip' => $values->zip,
            'country' => $values->country,
            'insurer_id' => $values->insurer
        ]);

        if($values->password) {
            $sys_user->update(['password' => Passwords::hash($values->password)]);
        }

        $this->flashMessage("Vas profil bol upraveny", "success");
    }

    protected function createComponentUploadAvatar()
    {
        $form = new \Nette\Application\UI\Form;
        $form->addUpload('file', 'Avatar:');
        $form->addSubmit('Upload');
        $form->onSuccess[] = function(\Nette\Application\UI\Form $form) {
            $values = $form->getValues();
            $path = "image/avatar/".$this->user->getId();
            $values->file->move($path);
            $this->userService->getByID($this->user->getId())->update([
                'avatar' => '/'.$path
            ]);
            $this->redirect('Homepage:default');
        };

        return $form;
    }

}