<?php

namespace App\Controllers;

use App\Business\MeseroBSN;

class WaiterController extends ControllerBase
{

    // Business

    private $meseroBsn;

    public function initialize(){
        $this->meseroBsn = new MeseroBSN();
    }    


    /**
    * Index
    *
    *
    * @author osanmartin
    *
    * Carga lista de mesas para un mesero determinado.
    *
    */
	
    public function indexAction()
    {


        //DATO EN BRUTO
        $id_mesero = 1;

    	#js custom
        $this->assets->addJs('js/pages/waiter.js');

        $datetime = new \DateTime('now');

        $paramMesas = ['funcionario_id' => $id_mesero, 
                       'fecha' => $datetime->format('Y-m-d'),
                       'turno' => $datetime->format('H:i:s')];

        $mesas = $this->meseroBsn->getMesas($paramMesas);
        $estadosMesa = $this->meseroBsn->getEstadosMesa($paramMesas);
        $pedidosPendientes = $this->meseroBsn->getPedidosPendientesMesasFuncionario($paramMesas);
        $pedidosTotales = $this->meseroBsn->getPedidosTotalesMesasFuncionario($paramMesas);

        if(!$mesas)
            $mesas = array();

        #vista
        $this->view->setVar("mesas",$mesas) ;
        $this->view->setVar("pedidosPendientes",$pedidosPendientes) ;
        $this->view->setVar("pedidosTotales",$pedidosTotales) ;
        $this->view->setVar("estadosMesa",$estadosMesa) ;
        $this->view->pick("controllers/waiter/_index");
    }

    public function tableDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/waiter/tables/modal";
            $this->mifaces->newFaces();


	        $dataView = "Holiwi";
	       
	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('table-modal',$toRend);
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}	


}

