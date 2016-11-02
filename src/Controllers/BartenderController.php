<?php

namespace App\Controllers;


use App\Business\PedidoBSN;
use App\Business\ProductoBSN;

use App\library\Constants\Constant;



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



        $this->view->setVar("orders", $orders_drinks_pdte);
        #View
        $this->view->pick("controllers/bartender/_index");
    }


    /**
    * changeCompletedOrders
    *
    * @author osanmartin
    *
    * Renderiza la vista de pedidos listos
    *
    *
    */    

    public function changeCompletedOrdersAction(){

        if($this->request->isAjax()){

            $view = "controllers/bartender/tables/_index";
            $this->mifaces->newFaces();


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

            $dataView['orders'] = $orders_drinks_pdte;


            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('tables-content',$toRend);
            $this->mifaces->addToDataView("menuNav", "opcion1");

            $this->mifaces->run();

        } else{

            $this->view->disable();

        }

    } 

    /**
    * changeCompletedOrders
    *
    * @author osanmartin
    *
    * Renderiza la vista de pedidos completos
    *
    *
    */    

    public function changePendingOrdersAction(){

        if($this->request->isAjax()){

            $view = "controllers/bartender/tables/_index";
            $this->mifaces->newFaces();


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

            $dataView['orders'] = $orders_drinks_pdte;


            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('tables-content',$toRend);

            $this->mifaces->run();

        } else{

            $this->defaultRedirect();

        }

    }       


    /**
    * completeOrders
    *
    * @author osanmartin
    *
    * Cambia el estado de un pedido
    *
    *
    */    

    public function completeOrderAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/bartender/tables/_index";
            $this->mifaces->newFaces();


            if(isset($post['pedido'])){

                $param['pedido_id'] = $post['pedido'];

                $pedidoBsn = new PedidoBSN();
                $result = $pedidoBsn->concretarPedido($param);

                if($result){

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

                    $dataView['orders'] = $orders_drinks_pdte;


                    $toRend = $this->view->getPartial($view, $dataView);

                    $this->mifaces->addToRend('tables-content',$toRend);
                    $this->mifaces->addToMsg('success','Pedido concretado exitosamente!');

                } else{

                    $this->mifaces->addToMsg('danger','No se pudo completar el pedido.');                   
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