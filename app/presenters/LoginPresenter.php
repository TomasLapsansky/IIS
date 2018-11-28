<?php

namespace App\Presenters;


use Nette\Application\UI;
use Nette\Security\AuthenticationException;

final class LoginPresenter extends BasePresenter {

    protected function createComponentLoginForm() {

        $form = new UI\Form;
        $form->addEmail("email", "Email:")->setRequired();
        $form->addPassword("password", "Password:")->setRequired();
        $form->addSubmit("login", "Login");
        $form->onSuccess[] = [$this, "loginFormSucceeded"];

        return $form;
    }

    public function loginFormSucceeded(UI\Form $form, $values) {

        try {
            $this->user->login($values->email, $values->password);

            $this->redirect("Homepage:");

        } catch (AuthenticationException $e) {
            $this->flashMessage('Nespravne prihlasovacie meno alebo heslo', 'warning');
        }

    }

}