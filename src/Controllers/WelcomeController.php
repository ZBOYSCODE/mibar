<?php

namespace App\Controllers;

use App\Business\MeseroBSN;


class WelcomeController extends ControllerBase
{

    public function indexAction()
    {

    	#js custom
        $this->assets->addJs('js/pages/welcome.js');

    	if ( is_array( $this->session->get("auth-identity") )){

    		$this->contextRedirect("menu");

    	} else {

    	    $mesa = new MeseroBSN();

            if($this->session->get('table_id_tmp') == null) {


                $this->contextRedirect("scanner/show");

            } else {

                $param = [
                    "id" => $this->session->get('table_id_tmp')
                ];

                $mesa_actual = $mesa->getMesaPorId($param);

                if($mesa_actual){
                    $this->view->setVar("mesa", $mesa_actual);
                }
                else{
                    $this->view->setVar("mesa", " - ");
                }



                $this->view->pick("controllers/welcome/_index");
            }


                
    	}

    }



    public function preprocessingAction($numeroMesa) {


        if(isset($numeroMesa) && is_numeric($numeroMesa)){
            $this->session->set('table_id_tmp', $numeroMesa);
        }


        $this->contextRedirect("");

    }


}