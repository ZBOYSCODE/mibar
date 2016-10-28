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

     /**
    * TableDetails
    *
    *
    * @author Hernán Feliú
    *
    * Renderiza modal Detalles Mesa via mifaces
    *
    */

    public function tableDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            $view = "controllers/waiter/tables/modal";


            $table_id = $post['table_id'];
            $param['mesa_id'] = $table_id;

            $tabObj = new MeseroBSN();
            $tablesDetails = $tabObj->getDataCuentasByMesa($param);
            //print_r($tablesDetails);exit();
	        $dataView['detalles'] =  $tablesDetails;
	       
	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('table-modal',$toRend);
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}	


    /**
    * BillDetails
    *
    *
    * @author osanmartin
    *
    * Renderiza modal detalles cuenta via mifaces
    *
    */    

    public function billDetailsAction(){



        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            $view = "controllers/waiter/tables/modal_orders";


            $cuenta_id = $post['cuenta'];
            $param['cuenta_id'] = $table_id;

            $tabObj = new MeseroBSN();
            $tablesDetails = $tabObj->getDetalleMesa($param);
            
            $dataView['detalles'] =  $tablesDetails;
           
            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('table-modal',$toRend);
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }


    }





}

