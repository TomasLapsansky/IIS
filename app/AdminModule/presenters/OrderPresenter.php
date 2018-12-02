<?php

namespace App\AdminModule\Presenters;

use Nette\Application\UI;

final class OrderPresenter extends AdminBasePresenter {

    public function actionDefault() {
        if ($this->orderService->count() != 0) {
            $this->template->orders = $this->orderService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->order = $order = $this->orderService->getByID($id);
        $this->template->sys_user = $this->userService->getByID($order->user_id);

        $this->template->productsOrder = $this->orderDrugService->getAll()->where('order_id', $id);
        $this->template->products = $this->productService->getAll();
    }

    public function actionAdd() {
        $this->redirect("Order:");
    }

    public function actionEdit($id) {
        $order = $this->orderService->getByID($id);
        $this->template->order = $order;

        $this['editForm']->setDefaults([
            'status' => $order->status,
            'city' => $order->city,
            'zip' => $order->zip,
            'address' => $order->address,
            'id' => $order->id
        ]);

    }

    protected function createComponentAddForm()
    {
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form();
        $form->addText('user_id', 'Uzivatel ID:')->setRequired();
        $form->addText('city', 'Mesto:')->setRequired();
        $form->addText('zip', 'Zip:')->setRequired();
        $form->addText('address', 'Adresa:')->setRequired();
        $form->addSubmit('add', 'Add');
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

    public function addFormSucceeded(UI\Form $form, $values)
    {
        $sys_user = $this->userService->getByID($values->user_id);

        if($sys_user) {

            $this->userService->insert([
                'user_id' => $values->user_id,
                'status' => 'created',
                'city' => $values->city,
                'zip' => $values->zip,
                'address' => $values->address
            ]);

            $this->redirect('User:');

        } else {
            $this->flashMessage("Nespravne uzivatelske ID", "error");
        }
    }

    protected function createComponentEditForm()
    {
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form();
        $form->addText('name', 'Meno:')->setRequired();
        $form->addText('surname', 'Priezvisko:')->setRequired();
        $form->addEmail('email', 'Email:')->setRequired();
        $form->addPassword('password', 'Heslo:');
        $form->addSelect('role', 'Role:', [
            'user',
            'admin'
        ])->setRequired();
        $form->addText('city', 'Mesto:')->setRequired();
        $form->addText('address', 'Adresa:')->setRequired();
        $form->addText('zip', 'ZIP:')->setRequired();
        $form->addText('country', 'Stat:')->setRequired();
        $form->addSelect('insurer', 'Poistovna:', $insurers->fetchPairs('id', 'name'))->setRequired();
        $form->addSubmit('edit', 'Edit');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    public function editFormSucceeded(UI\Form $form, $values)
    {
        $sys_user = $this->userService->getByID($values->id);

        $sys_user->update([
            'name' => $values->name,
            'surname' => $values->surname,
            'email' => $values->email,
            'city' => $values->city,
            'address' => $values->address,
            'zip' => $values->zip,
            'country' => $values->country,
            'insurer_id' => $values->insurer
        ]);

        if($values->role == 'user') {
            $sys_user->update(['role' => 'user']);
        } elseif($values->role == 'admin') {
            $sys_user->update(['role' => 'admin']);
        }

        if($values->password) {
            $sys_user->update(['password' => $values->password]);
        }

        $this->redirect('User:');
    }

}