<?php

namespace App\Controllers;

use App\Business\MeseroBSN;
use App\Business\PedidoBSN;
use App\Business\CajaBSN;

class WaiterController extends ControllerBase
{

    // Business

    private $meseroBsn;
    private $pedidoBsn;
    private $cajaBsn;

    public function initialize(){

        parent::initialize();
        $this->meseroBsn = new MeseroBSN();
        $this->pedidoBsn = new PedidoBSN();
        $this->cajaBsn   = new CajaBSN();

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
    * details
    *
    *
    * @author Hernán Feliú
    *
    * Renderiza Detalles Mesa via mifaces
    *
    */

    public function tableDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            if (isset($post['table_id'])){
           
            $view = "controllers/waiter/tables/details";

            $table_id = $post['table_id'];
            $param['mesa_id'] = $table_id;

            $tabObj = new MeseroBSN();
            $tablesDetails = $tabObj->getDataCuentasByMesa($param);
         
            $dataView['detalles'] =  $tablesDetails;
            $dataView['numeroMesa'] = array_values($tablesDetails)[0]['cuenta']->Mesas->numero;
        
            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('waiter_tables_details_render',$toRend);

            }else{

                $this->mifaces->addToMsg('danger','Error Inesperado. Refresque la página.');

            }

            
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

            if(isset($post['cuenta'])){

                $view = "controllers/waiter/tables/orders";
                
                $cuenta_id = $post['cuenta'];
                $param['cuenta_id'] = $cuenta_id;


                $pedidosCuenta  = $this->pedidoBsn->getAllOrders($param);
                $cuenta         = $this->cajaBsn->getCuentaById($param);

                $dataView['pedidosCuenta']  =  $pedidosCuenta;
                $dataView['cuenta']         =  $cuenta;
                //print_r($cuenta);exit();
                
                $toRend = $this->view->getPartial($view, $dataView);

                $this->mifaces->addToRend('table_modal_orders_render',$toRend);

            }else{

                $this->mifaces->addToMsg('danger','Error Inesperado. Refresque la página.');
            }
           
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }


    }


    /**
    * validateOrders
    *
    *
    * @author osanmartin / Hernán Feliú
    *
    * cambia estado a una serie de pedidos 
    *
    */

    public function validateOrdersAction(){   

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            $resultValidacion = false;
            $resultCancelacion = false;

            if(isset($post['table_id'])) {

                if(isset($post['pedidosValidados'])){

                    $pedidosValidados = $post['pedidosValidados'];
                    $resultValidacion = $this->pedidoBsn->validateOrders($pedidosValidados);

                    if(!$resultValidacion){

                        $this->mifaces->addToMsg('warning','Los pedidos no han sido validados correctamente!');

                    }

                }
                elseif(isset($post['pedidosNoValidados'])){

                     $pedidosNoValidados = $post['pedidosNoValidados'];
                     $resultCancelacion = $this->pedidoBsn->cancelOrders($pedidosNoValidados);

                     if(!$resultCancelacion){

                        $this->mifaces->addToMsg('warning','Los pedidos no han sido cancelados correctamente!');

                    }

                }
                else {
                    $this->mifaces->addToMsg('error','Error interno!');
                }

                    if($resultValidacion || $resultCancelacion){

                         $this->mifaces->addToDataView('resultValidation', 1);

                    }else{
                        $this->mifaces->addToDataView('resultValidation', 0);
                    }

                    $this->mifaces->addToMsg('success','Los pedidos han sido procesados correctamente!');
                    
                    $param['mesa_id'] = $post['table_id'];

                    $tabObj = new MeseroBSN();
                    $tablesDetails = $tabObj->getDataCuentasByMesa($param);

                    $dataView['detalles'] =  $tablesDetails;
                    $dataView['numeroMesa'] = array_values($tablesDetails)[0]['cuenta']->Mesas->numero;

                    $view = "controllers/waiter/tables/details";
                 
                    $toRend = $this->view->getPartial($view, $dataView);
                    $this->mifaces->addToRend('waiter_tables_details_render',$toRend);

            }
            else {
                $this->mifaces->addToMsg('error','Error interno!');
            }
            
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }      

    }

}

