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
        private $productoBsn;

        public function __construct()
        {
            $this->promocionBsn = new PromocionBSN();
            $this->productoBsn = new ProductoBSN();
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

            if(!isset($param['cuenta_id']) OR
               !isset($param['pedidos'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $cuenta_id  = $param['cuenta_id'];
            $pedidos = $param['pedidos'];

            $precioProductosList    = $this->productoBsn->getPreciosProducto($pedidos);
            $precioPromocionesList  = $this->promocionBsn->getPreciosPromocion($pedidos);

            foreach ($pedidos as $val) {

                $val['cuenta_id'] = $cuenta_id;

                if($val['es_promocion']){
                    
                    $val['precio'] = $precioPromocionesList[$val['producto_id']]->precio;
                    $result = $this->createOrderPromocion($val);

                }else{

                    $val['precio'] = $precioProductosList[$val['producto_id']]->precio;
                    $result = $this->createOrderProducto($val);

                }

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
                $pedido->precio = $param["precio"];
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
                $pedido->precio = $param["precio"];
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
            if(is_object($param)) {

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


        /**
         * Guarda el pedido en sesion
         *
         * guarda la lista de productos en sesion, antes de crear una orden !!
         * 
         * @author Sebastián Silva
         *
         * @param array $param
         * @return boolean
         */
        public function savePedidoSesion($param) {

            if(!isset($param['pedidos']) AND !isset($param['pedidos'])) {

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }  

            $list_pedidos = array();

            try {

                if ($this->session->has("pedidos")) {
                    // Retrieve its value
                    $pedidos = $this->session->get("pedidos");

                    foreach ($pedidos as $pedido) {
                            
                        array_push($list_pedidos, $pedido);
                    }
                }

                foreach ($param['pedidos'] as $pedido) {
                    
                    $ped = array(
                        'producto_id'   => $pedido->producto,
                        'cantidad'      => $pedido->cantidad,
                        'es_promocion'  => $pedido->promocion,
                        'comentario'    => $pedido->comment
                    );

                    array_push($list_pedidos, $ped);
                }

                $this->session->set('pedidos', $list_pedidos);

                return true;
                
            } catch (Exception $e) {

                return false;
            }
        }



        /**
         * Guarda el pedido en sesion
         *
         * guarda la lista de productos en sesion, antes de crear una orden !!
         * 
         * @author Sebastián Silva
         *
         * @param array $param
         * @return boolean
         */
        public function getPedidos() {


            if ($this->session->has("pedidos")) {
                
                $lista = array();

                $promos = array();
                $prod = array();
                
                $pedidos = $this->session->get("pedidos");


                $precioProductosList = $this->productoBsn->getPreciosProducto($pedidos);
                $precioPromocionesList = $this->promocionBsn->getPreciosPromocion($pedidos);

                if(!empty($precioProductosList)){

                    foreach ($precioProductosList as $producto) {

                        $prod[$producto->id] = array(
                            'precio'        => $producto->precio,
                            'nombre'        => $producto->nombre,
                            'descripcion'   => $producto->descripcion,
                            'avatar'        => $producto->avatar
                        );
                    
                    }
                }


                if(!empty($precioPromocionesList)){

                    foreach ($precioPromocionesList as $promocion) {

                        $promos[$promocion->id] = array(
                            'precio'        => $promocion->precio,
                            'nombre'        => $promocion->nombre,
                            'descripcion'   => $promocion->descripcion,
                            'avatar'        => $promocion->avatar
                        );
                    }
                }


                $pedidos = json_decode(json_encode($pedidos), FALSE);


                if( count($pedidos) == 0){
                    return array();
                }

                # recorremos los pedidos
                foreach ($pedidos as $key => &$pedido) { 

                    #separamos las promociones de los productos
                    if($pedido->es_promocion) {

                        $pedido->num_pedido         = $key;
                        $pedido->precio             = $promos[$pedido->producto_id]['precio'] * $pedido->cantidad;
                        $pedido->precio_unitario    = $promos[$pedido->producto_id]['precio'];
                        $pedido->nombre             = $promos[$pedido->producto_id]['nombre'];
                        $pedido->descripcion        = $promos[$pedido->producto_id]['descripcion'];
                        $pedido->avatar             = $promos[$pedido->producto_id]['avatar'];

                    } else {
                        $pedido->num_pedido         = $key;
                        $pedido->precio             = $prod[$pedido->producto_id]['precio'] * $pedido->cantidad;
                        $pedido->precio_unitario    = $prod[$pedido->producto_id]['precio'];
                        $pedido->nombre             = $prod[$pedido->producto_id]['nombre'];
                        $pedido->descripcion        = $prod[$pedido->producto_id]['descripcion'];
                        $pedido->avatar             = $prod[$pedido->producto_id]['avatar'];
                    }
                }

                return $pedidos;

            } else {

                return array();
            }
        }

        

    }



















