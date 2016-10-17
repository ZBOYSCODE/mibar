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

        private $promocionBsn;

        public function __construct()
        {
            $this->promocionBsn = new PromocionBSN();
        }



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

            $this->db->begin();

            if(count($param) == 0){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            foreach ($param as $val) {

                if($val["es_promocion"])
                    $result = $this->createOrderPromocion($val);
                else
                    $result = $this->createOrderProducto($val);

                if(!$result){
                    $this->db->rollback();
                    return false;
                }

            }

            $this->db->commit();

            return true;
        }

        /**
         * Crea pedidos específicos para producto
         *
         * @author osanmartin
         * @param $param = Array de datos para crear un pedido
         *
         * @return boolean
         */        

        private function createOrderProducto($param){

            // Cantidad de productos pedidos
            for ($i=0; $i < $param["cantidad"] ; $i++) { 

                $pedido = new Pedidos();

                $pedido->producto_id = $param["producto_id"];
                $pedido->cuenta_id = $param["cuenta_id"];
                $pedido->precio = $param["precio"]/$param["cantidad"];
                $pedido->comentario = $param["comentario"];
                $pedido->estado_id = 1;

                $result = $this->createPedido($pedido);

                if(!$result)
                    return false;
            }

            return true;            
        }

        /**
         * Crea pedidos específicos para producto
         *
         * @author osanmartin
         * @param $param = Array de datos para crear un pedido de promocion,
         *                 Adicionalmente crea registros en productoPromoPedidos,
         *                 que sirve para dividir las promociones en los productos
         *                 que correspondan.
         *
         * @return boolean
         */          


        public function createOrderPromocion($param){


            $dataPromocion = ['promocion_id' => $param['producto_id']];

            $result = $this->promocionBsn->getPromocion($dataPromocion);

            if(!$result){
                $this->error[] = $this->promocionBsn->error;
                return false;
            }

            $promocion = $result;

            $productosPromo = $promocion->ProdPromo;

            // Cantidad de promos pedidas
            for ($i=0; $i < $param["cantidad"] ; $i++) { 

                $pedido = new Pedidos();

                $pedido->promocion_id = $param["producto_id"];
                $pedido->cuenta_id = $param["cuenta_id"];
                $pedido->precio = $param["precio"]/$param["cantidad"];
                $pedido->comentario = $param["comentario"];
                $pedido->estado_id = 1;

                $result = $this->createPedido($pedido);

                if(!$result){
                    return false;
                }

                $pedido_id = $result;

                // Se registra la division de los productos asociados a la promo
                foreach ($productosPromo as $prodPromo) {

                    $prodPromoPedido = new ProducPromoPedidos();
                    $prodPromoPedido->pedido_id = $pedido_id;
                    $prodPromoPedido->producto_id = $prodPromo->producto_id;
                    $prodPromoPedido->estado_id = 1;

                    $result = $this->createProductoPromoPedido($prodPromoPedido);

                    if(!$result){
                        return false;
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
         * 
         *
         * @author osanmartin
         * @param $param = objeto seteado previamente.
         *
         * @return boolean
         */   

        public function createProductoPromoPedido($param){

            $prodPromoPedido = $param;

            if($prodPromoPedido->save() == false){
                foreach ($prodPromoPedido->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                return false;

            } else{

                return $prodPromoPedido->id;

            }
        }



    }



















