<?php

namespace App\Controllers;



class WelcomeController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->pick("controllers/welcome/_index");
    }

}