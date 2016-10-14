<?php

namespace App\Controllers;



class WelcomeController extends ControllerBase
{

    public function indexAction()
    {
    	#js custom
        $this->assets->addJs('js/pages/welcome.js');

        #vista
        $this->view->pick("controllers/welcome/_index");
    }

}