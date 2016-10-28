<?php

namespace App\Controllers;



class WelcomeController extends ControllerBase
{

    public function indexAction()
    {

    	#js custom
        $this->assets->addJs('js/pages/welcome.js');

    	if ( is_array( $this->session->get("auth-identity") )){

    		$this->contextRedirect("menu");

    	} else {
    		$this->view->pick("controllers/welcome/_index");
    	}

    }



    public function preprocessingAction($numeroMesa) {


        if(isset($numeroMesa) && is_numeric($numeroMesa)){
            $this->session->set('table_id_tmp', $numeroMesa);
        }


        $this->contextRedirect("");

    }


}