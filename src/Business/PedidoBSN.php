<?php
    /**
     * Modelo de negocio PedidoBSN
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * a la creación de pedidos
     *
     * @package      MiBar
     * @subpackage   Pedido Business
     * @category     Pedidos y relacionados
     * @author       Zenta Group Viña del Mar
     */


    namespace App\Business;
    
    use Phalcon\Mvc\User\Plugin;
    use App\Models\Pedidos;
    use App\Models\ProducPromoPedidos;
    use App\Models\Promociones;
    
    /**
     * Modelo de negocio
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * a los pedidos.
     *
     * @author Zenta Group Viña del Mar
     */
    class PedidoBSN extends Plugin
    {
        /**
         *
         * @var array
         */
    	public 	$error;



        /**
         * Crea Ordenes de Pedidos
         *
         * @author osanmartin
         * @param $param = [ 0 =>
         *                      [ 
         *                         "user_id" => integer
         *                         "producto_id" => integer
         *                         "precio" => integer
         *                         "cantidad" => integer 
         *                         "comentario" => text
         *                         "es_promocion" => true/false
         *                      ],
         *                     ...
         *
         *                 ]
         * @return boolean
         */
        public function createOrder($param){

            if(count($param) == 0){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            foreach ($param as $val) {

                if($val["es_promocion"]){



                } 

                // Cantidad de productos o promos pedidas
                for ($i=0; $i < $val["cantidad"] ; $i++) { 

                    $pedido = new Pedidos();

                    // Diferenciacion si es promo o producto individual
                    if($val["es_promocion"]){

                        $pedido->promocion_id = $val["producto_id"];

                    } else {

                        $pedido->producto_id = $val["producto_id"];

                    }

                    $pedido->cuenta_id = $val["cuenta_id"];
                    $pedido->precio = $val["precio"]/$val["cantidad"];
                    $pedido->comentario = $val["comentario"];
                    $pedido->estado_id = 1;

                    $result = $this->createPedido($pedido);

                    if(!$result)
                        return false;

                    if($val["es_promocion"]){
                        $this->createProductoPromoPedido();
                    }                    
                }
            }

            return true;
        }

        /**
         * Crea un Pedido
         *
         * @author osanmartin
         * @param $param = Array u objeto seteado previamente.
         *
         * @return boolean
         */        

        public function createPedido($param){

            // CASO 1: $param es un objeto pedido
            if(is_object($param)){

                $pedido = $param;

                if($pedido->save() == false)
                {
                    foreach ($pedido->getMessages() as $message) {
                        $this->error[] = $message->getMessage();
                    }
                    return false;
                } else{
                    return $pedido->id;
                }    
            }  else{
                $pedido = new Pedidos();
            }


            // CASO 2: $param es un array

            if(!isset($param['producto_id']) AND !isset($param['promocion_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }
  
            foreach ($param as $key => $val) {
                $pedido->$key = $val;
            }

            if ($pedido->save() == false)
            {
                foreach ($pedido->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                return false;
            } else{
                return $pedido->id;
            }
        }

        /**
         * Crea un ProductoPromoPedido
         *
         * @author osanmartin
         * @param $param = Array u objeto seteado previamente.
         *
         * @return boolean
         */                

    }



















