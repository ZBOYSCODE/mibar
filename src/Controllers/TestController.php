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

        $paramProdPedido = [

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
                       'precio' => 6000,
                       'cantidad' => 2,
                       'comentario' => '',
                       'es_promocion' => false]                            
                    ];

        $pedidoBsn = new PedidoBSN();
        $result = $pedidoBsn->createOrder($paramProdPedido);
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

        if(!$mesasporFuncionario){
            print_r($meseroBSN->error);
            die();
        }

        print_r($mesasporFuncionario->toArray());
        die();
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

    public function getCuentaAction(){

        $meseroBSN = new MeseroBSN();

        $param = array( "mesa_id" => "1",
                        "bar_id"  => "1"
                         );

        $cuentas = $meseroBSN->getDetalleMesa($param);
        $total = 0;
        foreach ($cuentas as $cuenta) {
            echo "<pre>";
            echo "Numero de Cuenta:".$cuenta->id;
            echo "<br>";
            echo "Nombre asociado: ".$cuenta->Clientes->nombre;
            echo "<br>";
            echo "<br>";
            echo "Pedido";
            echo "<br>";
            echo "<br>";
            echo "Numero de Pedidos: ".$cuenta->Pedidos->count();
            echo("<br>");

            foreach ($cuenta->Pedidos as $pedido) {
                echo "========================================================";
                echo "<pre>";
                echo "Numero de Pedido".$pedido->id;
                echo "<br>";
                echo "<br>";
                echo "Productos asociados";
                echo "<br>";
                echo "<pre>";
                echo "<br>";
                $total += $pedido->precio;
                echo $pedido->precio;

                if(is_null($pedido->producto_id)){
                    echo "<pre>";
                    echo $pedido->Promociones->nombre;   
                    foreach ($pedido->ProducPromoPedidos as $productoPromoPedido ) {
                        echo "<br>";
                        echo " Producto: ".$productoPromoPedido->Productos->nombre;
                        echo "<br>";
                    }

                }else{ 

                    $producto = $pedido->Productos;
                        echo "<br>";
                        echo " Producto: ".$producto->nombre;
                        echo "<br>";
                }
                
                echo "========================================================";         
            }





        }
        echo "<pre>";
        echo "Total";
        echo " ".$total;
    }



}
