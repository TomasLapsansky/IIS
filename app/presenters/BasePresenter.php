<?php

namespace App\Presenters;

use Models\Drug;
use Models\Insurer;
use Models\Order;
use Models\Producer;
use Models\User;
use Nette;

class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var Nette\Database\Context @inject */
    public $database;

    /** @var User @inject */
    public $userService;

    /** @var Drug @inject */
    public $productService;

    /** @var Producer @inject */
    public $producerService;

    /** @var Order @inject */
    public $orderService;

    /** @var Insurer @inject */
    public $insurerService;
}