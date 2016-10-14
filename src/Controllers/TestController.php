<?php

namespace App\Controllers;
use App\Business\PedidoBSN;



class TestController extends ControllerBase
{

    public function indexAction()
    {

        $this->view->pick("test/test_form");

    }

    public function createOrderAction(){

        $param = [ 
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
                       'cantidad' => 1,
                       'comentario' => '',
                       'es_promocion' => false]                  
               ];

        $param = [ 
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
        $result = $pedidoBsn->createOrder($param);
        if(!is_object($result))
            var_dump($result);
        print_r($pedidoBsn->error);

    }

}