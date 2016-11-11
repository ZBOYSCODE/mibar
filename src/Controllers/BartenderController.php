<?php

namespace App\Controllers;


use App\Business\PedidoBSN;
use App\Business\ProductoBSN;

use App\library\Constants\Constant;

use App\Models\FuncionarioMesa;



class BartenderController extends ControllerBase
{

    private $constant;

    /**
     * initialize
     *
     * @author Jorge Silva
     *
     * inicializa la clase
     */
    public function initialize()
    {
        parent::initialize();

        $this->constant = new Constant();
    }


    /**
     * indexAction
     *
     * @author Jorge Silva
     *
     * Index de la pagina de bar, renderiza los pedidos pendientes.
     *
     */
    public function indexAction()
    {
        #js custom
        $this->assets->addJs('js/pages/bartender.js');

        #traemos todos los pedidos con estado
        $arr = $this->getData();

        $this->view->setVar("orders", $arr);
        $this->view->pick("controllers/bartender/_index");
    }

    public function renderPageAction(){

        # traemos todos los pedidos con estado
        $arr = $this->getData();

        # enviamos los datos a la vista y obtenemos el html listo
        $dataView['orders'] = $arr;
        $view = "controllers/bartender/tables/pending";
        $toRend = $this->view->getPartial($view, $dataView);

        # ejecutamos miface para renderizar
        $this->mifaces->newFaces();
        $this->mifaces->addToRend('tables-content',$toRend);
        $this->mifaces->addToDataView("menuNav", "opcion1");
        $this->mifaces->run();
    }

    public function renderPageListosAction() {

        $view = "controllers/bartender/tables/complete";
        
        $dataView['orders'] = $this->getDataListos();

        $toRend = $this->view->getPartial($view, $dataView);
        
        $this->mifaces->newFaces();
        $this->mifaces->addToRend('tables-content',$toRend);
        $this->mifaces->addToDataView("menuNav", "opcion1");
        $this->mifaces->run();

    }

    private function getData(){

        $param = [
            "nombre" => $this->constant->ESTADO_PEDIDO_EN_PROCESO
        ];

        $paramCat = [
            "nombre" => $this->constant->PEDIDO_BEBIDA
        ];

        $pedidobsnObj = new PedidoBSN();
        $status = $pedidobsnObj->getStatus($param);

        $productoObj = new ProductoBSN();
        $category = $productoObj->getListCategoriesByName($paramCat);



        if($status == false OR $category == false)
        {
            $orders_drinks_pdte = false;
        }
        else {

            $paramOrder = [
                "category_id"    => $category->id ,
                "estado_id"      => $status->id
            ];

            $orders_drinks_pdte = $pedidobsnObj->getOrdersByCategoryStatus($paramOrder);

        }

        $arr = array();

        if( $orders_drinks_pdte !== false ) {

            if( count($orders_drinks_pdte) > 0 ){

                foreach ($orders_drinks_pdte as $key => $orden) {

                    $fecha = str_replace(' ', '', $orden->created_at);
                    $fecha = str_replace('-', '', $fecha);
                    $fecha = str_replace(':', '', $fecha);

                    $arr[ $orden->created_at ][$orden->cuenta_id]['fecha']      = $fecha;
                    $arr[ $orden->created_at ][$orden->cuenta_id]['fecha2']      = date('H:i' ,strtotime( $orden->created_at));
                    $arr[ $orden->created_at ][$orden->cuenta_id]['orden'][]    = $orden;
                    $arr[ $orden->created_at ][$orden->cuenta_id]['mesa_id']    = $orden->mesa_id;
                }
            }
        }
        
        return $arr;
    }


    private function getDataListos(){

        $param = [
            "nombre" => $this->constant->ESTADO_PEDIDO_CONCRETADO
        ];

        $paramCat = [
            "nombre" => $this->constant->PEDIDO_BEBIDA
        ];

        $pedidobsnObj = new PedidoBSN();
        $status = $pedidobsnObj->getStatus($param);

        $productoObj = new ProductoBSN();
        $category = $productoObj->getListCategoriesByName($paramCat);



        if($status == false OR $category == false)
        {
            $orders_drinks_pdte = false;
        }
        else {

            $paramOrder = [
                "category_id"    => $category->id ,
                "estado_id"      => $status->id
            ];

            $orders_drinks_pdte = $pedidobsnObj->getOrdersByCategoryStatus($paramOrder);

        }

        //return $orders_drinks_pdte;

        $arr = array();

        if( $orders_drinks_pdte !== false ) {

            if( count($orders_drinks_pdte) > 0 ){

                foreach ($orders_drinks_pdte as $key => $orden) {

                    $fecha = str_replace(' ', '', $orden->created_at);
                    $fecha = str_replace('-', '', $fecha);
                    $fecha = str_replace(':', '', $fecha);

                    $arr[ $orden->created_at ][$orden->cuenta_id]['fecha']      = $fecha;
                    $arr[ $orden->created_at ][$orden->cuenta_id]['fecha2']      = date('H:i' ,strtotime( $orden->created_at));
                    $arr[ $orden->created_at ][$orden->cuenta_id]['orden'][]    = $orden;
                    $arr[ $orden->created_at ][$orden->cuenta_id]['mesa_id']    = $orden->mesa_id;
                }
            }
        }

        return $arr;
    }



    /**
    * completeOrders
    *
    * @author osanmartin
    *
    * Cambia el estado los pedidos a concretados
    *
    *
    */    
    public function completeOrderAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/bartender/tables/pending";
            $this->mifaces->newFaces();


            if( isset($post['pedido']) ) {

                $param['pedido_id'] = $post['pedido'];

                $pedidoBsn  = new PedidoBSN();
                $result     = $pedidoBsn->concretarPedido($param);

                if($result) {

                    $this->mifaces->addToDataView("pedido_eliminado", trim($post['pedido']));
                } else {

                    $this->mifaces->addToDataView("pedido_eliminado", "false");
                    $this->mifaces->addToMsg('danger','No se pudo completar el pedido.');                   
                }
            } else{

                $this->mifaces->addToDataView("pedido_eliminado", "false");
                $this->mifaces->addToMsg('danger','Error inesperado.');
            }

            $this->mifaces->run();
        } else{

            $this->defaultRedirect();
        }
    }  



    /**
    * orderDetails
    *
    * @author osanmartin
    *
    * Muestra el detalle de un pedido
    *
    */

    public function orderDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/bartender/tables/details";
            $this->mifaces->newFaces();


            if(isset($post['pedido'])){

                $param['pedido_id'] = $post['pedido'];

                $pedidoBsn = new PedidoBSN();

                $result = $pedidoBsn->getPedido($param);

                if($result){

                    $pedido = $result;

                    $dataView['pedido'] = $pedido;

                    $datetime = new \DateTime($pedido->created_at);

                    $dataView['fecha']  = $datetime->format('d-m-Y');
                    $dataView['hora']  = $datetime->format('H:i');


                    $dataView['mesero'] = $pedido->Cuentas->Mesas->FuncionarioMesa->getFirst()->Funcionarios; 

                    $toRend = $this->view->getPartial($view, $dataView);

                    $this->mifaces->addToRend('modal-content',$toRend);
                
                } else {

                    $this->mifaces->addToMsg('danger','Error inesperado con el pedido.');

                }
                

            } else{

                $this->mifaces->addToMsg('danger','Error inesperado.');

            }

            $this->mifaces->run();

        } else{

            $this->defaultRedirect();

        }

    } 

}