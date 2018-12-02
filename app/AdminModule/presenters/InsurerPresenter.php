<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Insurer;
use Nette;
use Nette\Application\UI;

final class InsurerPresenter extends AdminBasePresenter {

    /** @var Insurer @inject */
    public $insurerService;

    public function actionDefault() {
        if ($this->insurerService->count() != 0) {
            $this->template->insurers = $this->insurerService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->insurer = $this->insurerService->getByID($id);

        $this->template->insuredProducts = $this->drugInsurerService->getAll()->where('insurer_id', $id);
        $this->template->products = $this->productService;
    }

    public function actionAdd() {
        
    }

    public function actionEdit($id) {
        $insurer = $this->insurerService->getByID($id);
        $this->template->insurer = $insurer;

        $this['editForm']->setDefaults([
            'name' => $insurer->name,
            'id' => $insurer->id
        ]);

    }

    protected function createComponentEditForm()
    {
        $form = new UI\Form();
        $form->addHidden("id");        
        $form->addText('name', 'Insurer name:')->setRequired();
        $form->addSubmit("edit", "save");
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    public function editFormSucceeded(UI\Form $form, $values)
    {
        $insurer = $this->insurerService->getByID($values->id);

        $insurer->update([
            'name' => $values->name,
        ]);

        $this->redirect('Insurer:');
    }

    protected function createComponentAddForm()
    {
        $form = new UI\Form();    
        $form->addText('name', 'Insurer name:')->setRequired();
        $form->addSubmit("add", "Add");
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

    public function addFormSucceeded(UI\Form $form, $values)
    {
        $this->insurerService->insert([
            'name' => $values->name,
        ]);

        $this->redirect('Insurer:');
    }

}