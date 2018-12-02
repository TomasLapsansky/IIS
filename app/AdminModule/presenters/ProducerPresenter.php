<?php

namespace App\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Models\Producer;
use Nette;
use Nette\Application\UI;

final class ProducerPresenter extends AdminBasePresenter {
    
    /** @var Producer @inject */
    public $producerService;

    public function actionDefault() {
        if ($this->producerService->count() != 0) {
            $this->template->producers = $this->producerService->getAll();
        }
    }

    public function actionDetail($id) {
        $this->template->id = $id;
        $this->template->producer = $this->producerService->getByID($id);
        $this->template->products = $this->productService->getAll()->where('producer', $id);
    }

    public function actionEdit($id) {
        $producer = $this->producerService->getByID($id);
        $this->template->producer = $producer;

        $this['editForm']->setDefaults([
            'name' => $producer->name,
            'time' => $producer->time_delivery,
            'id' => $producer->id
        ]);

    }

    protected function createComponentEditForm()
    {
        $form = new UI\Form();
        $form->addHidden("id");        
        $form->addText('name', 'Producer name:')->setRequired();
        $form->addInteger('time', 'Delivery time:')->setRequired();
        $form->addSubmit("edit", "save");
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    public function editFormSucceeded(UI\Form $form, $values)
    {
        $producer = $this->producerService->getByID($values->id);

        $producer->update([
            'name' => $values->name,
            'time_delivery' => $values->time
        ]);

        $this->redirect('Producer:');
    }

    protected function createComponentAddForm()
    {
        $form = new UI\Form(); 
        $form->addText('name', 'Producer name:')->setRequired();
        $form->addInteger('time', 'Delivery time:')->setRequired();
        $form->addSubmit("add", "Add new");
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
        return $form;
    }

    public function addFormSucceeded(UI\Form $form, $values)
    {
        $this->producerService->insert([
            'name' => $values->name,
            'time_delivery' => $values->time
        ]);

        $this->redirect('Producer:');
    }



}