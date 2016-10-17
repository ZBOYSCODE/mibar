<?php

namespace App\Controllers;
use App\Business\PedidoBSN;
use App\Business\ProductoBSN;
use App\Business\MeseroBSN;


class TestController extends ControllerBase
{

    public function indexAction()
    {

        $this->view->pick("test/test_form");

    }

    public function createOrderAction(){

        $paramProd = [ 
                   0 => 
                       ['cuenta_id' => 1, 
                       'producto_id' => 1,
                       'precio' => 3500,
                       'cantidad' => 2,
                       'comentario' => 'Sin hielo',
                       'es_promocion' => false], 
                   1 => 
                       ['cuenta_id' => 1, 
                       'producto_id' => 2,
                       'precio' => 6000,
                       'cantidad' => 2,
                       'comentario' => '',
                       'es_promocion' => false]                  
               ];

        $paramPromo = [ 
                   0 => 
                       ['cuenta_id' => 1, 
                       'producto_id' => 1,
                       'precio' => 6000,
                       'cantidad' => 1,
                       'comentario' => '',
                       'es_promocion' => true], 
                   1 => 
                       ['cuenta_id' => 1, 
                       'producto_id' => 2,
                       'precio' => 10000,
                       'cantidad' => 2,
                       'comentario' => '',
                       'es_promocion' => true]                  
               ];               

        $pedidoBsn = new PedidoBSN();
        $result = $pedidoBsn->createOrder($paramPromo);
        if(!is_object($result))
            var_dump($result);
        print_r($pedidoBsn->error);

    }

    public function getProductDetailsAction() {
        $productBSN = new ProductoBSN();

        $result = $productBSN->getProductDetails(array('id' => 5));
        //var_dump($result);

        echo $result->id;
    }

    public function getMesasAction(){

        $meseroBSN = new MeseroBSN();

        $fecha = new \DateTime('2016-10-17');

        $param = array( "funcionario_id" => "1",
                        "turno_id"       => "1",
                        "fecha"          => $fecha
                         );



        $mesasporFuncionario = $meseroBSN->getMesas($param);

        if($mesasporFuncionario==false){
            print_r($meseroBSN->error);
            die();
        }

        //relación automatica
        foreach ($mesasporFuncionario as $funcionarioMesa) {
            echo $funcionarioMesa->Mesas->numero;
            echo " ";
        }



    }
}