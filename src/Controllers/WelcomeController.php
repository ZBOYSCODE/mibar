<?php

namespace App\Controllers;



class WelcomeController extends ControllerBase
{

    public function indexAction()
    {
    	#js custom
        $this->assets->addJs('js/pages/welcome.js');

    	if ( is_array( $this->session->get("auth-identity") )){

    		$this->view->pick("controllers/menu/_index");

    	} else {

    		$this->view->pick("controllers/welcome/_index");
    	}

        

    }

}