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
        $this->template->insurer = $this->insurerService->getByID($id);
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
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form();
        $form->addHidden("id");        
        $form->addText('name', 'Producer name:')->setRequired();
        $form->addInteger('time', 'Delivery time:')->setRequired();
        $form->addSubmit("edit", "save");
        $form->onSuccess[] = [$this, 'editOnSucceeded'];
        return $form;
    }

    protected function createComponentAddForm()
    {
        $insurers = $this->insurerService->getAll();

        $form = new UI\Form(); 
        $form->addText('name', 'Producer name:')->setRequired();
        $form->addInteger('time', 'Delivery time:')->setRequired();
        $form->addSubmit("add", "Add new");
        $form->onSuccess[] = [$this, 'addOnSucceeded'];
        return $form;
    }



}