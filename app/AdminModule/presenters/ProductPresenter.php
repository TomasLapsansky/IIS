<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Nette;
use Nette\Application\UI;

final class ProductPresenter extends BasePresenter {

    public function actionDefault() {
        if ($this->productService->count() != 0) {
            $this->template->products = $this->productService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->product = $this->productService->getByID($id);
    }

    public function actionAdd() {

    }

    public function actionEdit($id) {
        $product = $this->productService->getByID($id);
        $this->template->product = $product;

        $this['editForm']->setDefaults([
            'name' => $product->name,
            'count' => $product->count,
            'producer' => $product->producer,
            'price' => $product->price,
            'description' => $product->description,
            'id' => $product->id
        ]);
    }

    protected function createComponentAddForm()
    {
        $producers = $this->producerService->getAll();

        $form = new UI\Form();
        $form->addText('name', 'Meno:')->setRequired();
        $form->addText('count', 'Pocet:')->setRequired();
        $form->addSelect('producer', 'Vyrobca:', $producers->fetchPairs('id', 'name'))->setRequired();
        $form->addText('price', 'Cena:')->setRequired();
        $form->addTextArea('description', 'Popis:')->setRequired();
        $form->addSubmit('add', 'Add');
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

    public function addFormSucceeded(UI\Form $form, $values)
    {
        $this->productService->insert([
            'name' => $values->name,
            'count' => $values->count,
            'producer' => $values->producer,
            'price' => $values->price,
            'description' => $values->description
        ]);

        $this->redirect('Product:');
    }

    protected function createComponentEditForm()
    {

        $form = new UI\Form();
        $form->getPresenter(false);
        $form->addText('name', 'Meno:')->setRequired();
        $form->addText('count', 'Pocet:')->setRequired();
        $form->addText('producer', 'Vyrobca:')->setRequired();
        $form->addText('price', 'Cena:')->setRequired();
        $form->addTextArea('description', 'Popis:')->setRequired();
        $form->addSubmit('edit', 'Edit');
        $form->addHidden('id');
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    public function editFormSucceeded(UI\Form $form, $values)
    {
        $product = $this->productService->getByID($values->id);

        $product->update([
            'name' => $values->name,
            'count' => $values->count,
            'producer' => $values->producer,
            'price' => $values->price,
            'description' => $values->description
        ]);

        $this->redirect('Product:');
    }

}