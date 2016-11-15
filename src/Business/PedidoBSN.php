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
    use App\Models\Estados;
    use App\Models\Productos;
    use App\Models\SubcategoriaProductos;
    use App\Models\CategoriaProductos;

    //DEFINE('PEDIDO_CANCELADO', 6);

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

        private $ESTADO_PEDIDO_VALIDADO = 2;
        private $ESTADO_PEDIDO_CANCELADO = 6;
        private $ESTADO_PEDIDO_CONCRETADO = 3;
        private $ESTADO_PEDIDO_ENTREGADO = 5;

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
                foreach ($pedidos as $key => $pedido) {

                    #separamos las promociones de los productos
                    if( $pedido->es_promocion ) {

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

        /**
         * getOrders
         *
         * retorna la lista de ordenes de una cuenta
         *
         * @author Sebastián Silva
         *
         * @param array $param
         * @return objects
         */
        public function getOrdersWithoutPayment($param) {

            if( !isset($param['cuenta_id'])) {
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            if( isset($param['estado_id']) ) {
                
                $where_estado = " AND estado_id = ".$param['estado_id'];
            } else {

                $where_estado = ' AND estado_id != 6';# estado anulado
            }

            $pedidos = Pedidos::find(
                array(
                    " cuenta_id = {$param['cuenta_id']} AND pago_id is null {$where_estado} ",
                    "order" => "id DESC"
                )
            );


            if( !$pedidos->count() ) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $pedidos;
        }


        /**
         * getOrdersByCategoryStatus
         *
         *
         * Retorna una lista de pedidos dada una categoria y un estado en particular
         * en caso de error retorna false
         *
         * @author Jorge Silva
         *
         * @param array $param ['category_id'   => integer
         *                      'estado_id'     => integer
         *                      ]
         * @return bool
         *
         *
         */
        public function getOrdersByCategoryStatus($param) {


            if( !isset($param["category_id"]) AND !isset($param["estado_id"])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }



            $pedidosProd = Pedidos::query()
                ->leftJoin('App\Models\Productos', 'prd.id   = App\Models\Pedidos.producto_id',    'prd')

                ->leftJoin('App\Models\SubcategoriaProductos', 'scp.id   = prd.subcategoria_id',    'scp')
                ->leftJoin('App\Models\CategoriaProductos', 'cat.id   = scp.categoria_producto_id',    'cat')
                ->where("cat.id = '{$param["category_id"]}' ")
                ->andWhere("App\Models\Pedidos.estado_id = '{$param["estado_id"]}' ")
                ->andWhere("App\Models\Pedidos.promocion_id is NULL")
                ->orderBy("App\Models\Pedidos.created_at ASC")
                ->execute();



            $pedidosPromo = Pedidos::query()
                ->leftJoin('App\Models\Promociones','prm.id  =
                App\Models\Pedidos.promocion_id',   'prm')            
                ->where("App\Models\Pedidos.estado_id = '{$param["estado_id"]}' ")
                ->andWhere("App\Models\Pedidos.producto_id is NULL")
                ->andWhere("prm.categoriaproducto_id = {$param["category_id"]}")
                ->orderBy("App\Models\Pedidos.created_at ASC")
                ->execute();

            if($pedidosProd->count() OR 
               $pedidosPromo->count()){

                foreach ($pedidosProd as $val) {

                    $val->nombre = $val->Productos->nombre;
                    $val->descripcion = $val->Productos->descripcion;
                    $val->avatar = $val->Productos->avatar;
                    $val->mesa_id = $val->Cuentas->mesa_id;

                    $arr[$val->id] = $val;

                }

                foreach ($pedidosPromo as $key => $val) {

                    $val->nombre = $val->Promociones->nombre;
                    $val->descripcion = $val->Promociones->descripcion;
                    $val->avatar = $val->Promociones->avatar;
                    $val->mesa_id = $val->Cuentas->mesa_id;

                    $arr[$val->id] = $val;

                }

                return $arr;


            }else{

                $this->error = $this->errors->NO_RECORDS_FOUND_ID;
                return false;
            }
        }

        /**
         * getAllOrders
         *
         * retorna todas las ordenes de una cuenta
         *
         * @author Sebastián Silva
         *
         * @param array $param
         * @return objects
         */
        public function getAllOrders($param) {

            if( !isset($param['cuenta_id'])) {
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            if(isset($param['estado_id'])){

                $pedidos = Pedidos::find(
                    array(
                        " cuenta_id = {$param['cuenta_id']} AND 
                        estado_id = {$param['estado_id']} ",
                        "order" => "id DESC"
                    )
                );

            } else {

                $pedidos = Pedidos::find(
                    array(
                        " cuenta_id = {$param['cuenta_id']}" ,

                        "order" => "id DESC"
                    )
                );

            }




            if( $pedidos->count() == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }


            return $pedidos;
        }

        /**
         * Trae la lista de productos y promociones que pertenecen a una cuenta
         * @param $param array  'cuenta_id'
         * @return array|bool
         */
        public function getProductosByCuenta($param)
        {
            if (!isset($param['cuenta_id'])) {
                $error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $pedidos = Pedidos::find("  pago_id is null 
                                    AND estado_id != ".PEDIDO_CANCELADO."
                                    AND cuenta_id = " . $param['cuenta_id']);
            if (!$pedidos->count()) {
                $error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }
            $result = array();
            foreach ($pedidos as $pedido) {
                if ($pedido->producto_id != null and $pedido->producto_id != 0) {
                    $producto = $this->productoBsn->getProducto(array('producto_id' => $pedido->producto_id));
                    if (!$producto->count()) {
                        $this->error[] = $this->errors->NO_RECORDS_FOUND;
                        return false;
                    }
                    $producto->precio = $pedido->precio;
                    $result[] = $producto;
                } else {
                    $producto = $this->promocionBsn->getPromocion(array('promocion_id' => $pedido->promocion_id));
                    if (!$producto->count()) {
                        $this->error[] = $this->errors->NO_RECORDS_FOUND;
                        return false;
                    }
                    $producto->precio = $pedido->precio;
                    $result[] = $producto;
                }
            }
            return $result;
        }
        /**
         * validarPedidos
         *
         * cambia estado a validado a todos los pedidos enviados
         *
         * @author osanmartin
         *
         * @param array $param listado de pedidos
         * @return boolean
         */

        public function validateOrders($param){

            $this->db->begin();


            if(!count($param)){

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }

            foreach ($param as $val) {

                $paramPedido['pedido_id'] = $val;
                $paramPedido['estado_id'] = $this->ESTADO_PEDIDO_VALIDADO;

                $result = $this->updatePedido($paramPedido);

                if(!$result){
                    $this->db->rollback();
                    return false;
                }

            }

            $this->db->commit();

            return true;

        }


        /**
         * anularPedidos
         *
         * cambia estado a cancelado todos los pedidos enviados
         *
         * @author osanmartin
         *
         * @param array $param listado de pedidos
         * @return boolean
         */

        public function cancelOrders($param){

            $this->db->begin();

            if(!count($param)){

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }

            foreach ($param as $val) {

                $paramPedido['pedido_id'] = $val;
                $paramPedido['estado_id'] = $this->ESTADO_PEDIDO_CANCELADO;

                $result = $this->updatePedido($paramPedido);

                if(!$result){
                    $this->db->rollback();
                    return false;
                }

            }

            $this->db->commit();

            return true;

        }        

        /**
        *
        * updatePedido
        *
        * Actualiza el estado de un pedido
        *
        * @author osanmartin
        *
        * @param $param array de datos de pedido a actualizar
        *
        * @return boolean
        *
        */
        public function updatePedido($param){

            if(!isset($param['pedido_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $pedido = Pedidos::findFirstById($param['pedido_id']);

            if(!$pedido){
                $this->error[] = $this->errors->NO_RECORDS_FOUND_ID;
                return false;
            }

            foreach ($param as $key => $val) {
                $pedido->$key = $val;
            }

            if ($pedido->update() == false)
            {
                foreach ($pedido->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                return false;
            } else{
                return true;
            }            

        }



        /**
         * getStatus
         *
         * Retorna un objeto Estado dado un nombre, si no se setea el parametro string se traen todos los Estados.
         *
         * si retorna false es porque hay errores
         *
         * @author Jorge Silva
         *
         * @param array $param[ 'nombre' => string ]
         * @return \App\Models\Estados[]|array|bool|id
         */
        public function getStatus($param) {

            $status = array();

            if(isset($param["nombre"])) {

                $status = Estados::findFirst(
                  array (
                      "nombre = '{$param['nombre']}' "
                  )
                );

            }
            else{
                $status = Estados::find();
            }

            if( $status == false ) {
                $this->error = $this->errors->NO_RECORDS_FOUND;
                return false;
            }


            return $status;
        }


        /**
        *
        * Concreta el pedido de parte del Barman
        *
        * Actualiza el estado de un pedido a concretado
        *
        * @author osanmartin
        *
        * @param $param['pedido_id'] : ID de pedido
        *
        * @return boolean
        *
        */

        public function concretarPedido($param){

            if(!isset($param['pedido_id'])){

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }


            $paramPedido['pedido_id'] = $param['pedido_id'];
            $paramPedido['estado_id']    = $this->ESTADO_PEDIDO_CONCRETADO;

            $result  = $this->updatePedido($paramPedido);

            if(!$result)
                return false;

            return true;

        }

        /**
        *
        * getPedido
        *
        * Obtiene un pedido
        *
        * @author osanmartin
        *
        * @param $param['pedido_id'] : ID de pedido
        *
        * @return boolean
        *
        */        

        public function getPedido($param) {


            if(!isset($param['pedido_id'])){

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }

            $result = Pedidos::findFirstById($param['pedido_id']);


            if(!$result){

                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;

            }

            if(isset($result->Productos->id)){

                $result->nombre = $result->Productos->nombre;
                $result->descripcion = $result->Productos->descripcion;
                $result->avatar = $result->Productos->avatar;

            } else if(isset($result->Promociones->id)) {

                $result->nombre = $result->Promociones->nombre;
                $result->descripcion = $result->Promociones->descripcion;
                $result->avatar = $result->Promociones->avatar;

            }

            return $result;

        }

          /**
         * entregarPedidos
         *
         * cambia estado a validado a todos los pedidos entregados
         *
         * @author Hernán Feliú
         *
         * @param array $param listado de pedidos entregados
         * @return boolean
         */

        public function deliverOrders($param){

            $this->db->begin();


            if(!count($param)){

                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }

            foreach ($param as $val) {

                $paramPedido['pedido_id'] = $val;
                $paramPedido['estado_id'] = $this->ESTADO_PEDIDO_ENTREGADO;

                $result = $this->updatePedido($paramPedido);

                if(!$result){
                    $this->db->rollback();
                    return false;
                }

            }

            $this->db->commit();

            return true;

        }



    }




















