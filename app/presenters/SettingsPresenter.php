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
        $form->addText('name', 'Meno:')->setRequired();
        $form->addText('surname', 'Priezvisko:')->setRequired();
        $form->addPassword('password', 'Heslo:');
        $form->addText('city', 'Mesto:')->setRequired();
        $form->addText('address', 'Adresa:')->setRequired();
        $form->addText('zip', 'PSČ:')->setRequired();
        $form->addText('country', 'Štát:')->setRequired();
        $form->addHidden('id');
        $form->addSelect('insurer', 'Poistovna:', $insurers->fetchPairs('id', 'name'))->setRequired();
        $form->addSubmit('edit', 'Uložiť');
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
        $form->addSubmit('Upload', 'Upload');
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