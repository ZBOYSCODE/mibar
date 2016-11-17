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


                if($mesa_actual !== false ){
                    $this->view->setVar("mesa", $mesa_actual->numero );
                }
                else{

                    $mesa_defecto = 1;

                    $this->session->set('table_id_tmp', $mesa_defecto);

                    $this->view->setVar("mesa", $mesa_defecto);
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