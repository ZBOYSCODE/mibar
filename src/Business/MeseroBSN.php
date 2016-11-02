<?php
    /**
     * Modelo de negocio MeseroBSN
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * al flujo de datos Mesero
     *
     * @package      MiBar
     * @subpackage   Mesero Business
     * @category     Mesas, mesero y relcionados
     * @author       Zenta Group Viña del Mar
     */


    namespace App\Business;
    
    use Phalcon\Mvc\User\Plugin;

    use App\Business\AccessBSN;

    use App\Models\Clientes;
    use App\Models\Mesas;
    use App\Models\FuncionarioMesa;
    use App\Models\Cuentas;
    use App\Models\Pedidos;
    use App\Models\EstadosMesa;
    /**
     * Modelo de negocio
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * al Mesero.
     *
     * @author Zenta Group Viña del Mar
     */
    class MeseroBSN extends Plugin
    {
        /**
         *
         * @var array
         */
        public  $error;

        private $ESTADO_CUENTA_PENDIENTE = 1;
        private $ESTADO_MESA_ACTIVA = 1;
        private $ESTADO_PEDIDO_PENDIENTE = 1;

        PRIVATE $ESTADO_MESA_OCUPADA = 2;

        public $estado_cancelado = 6;


        /**
        *
        * Obtiene mesas para un funcionario
        *
        * @author osanmartin
        *
        * @param $param['funcionario_id'] : ID de funcionario
        * @return lista de objetos Mesa asociados
        *
        *
        */

        public function getMesas($param){

            if(!isset($param['funcionario_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $result = Mesas::query()
                    ->leftJoin("App\Models\FuncionarioMesa","App\Models\Mesas.id = fm.mesa_id","fm")
                    ->where("fm.funcionario_id = {$param['funcionario_id']}")
                    ->andWhere("fm.activo = {$this->ESTADO_MESA_ACTIVA}")
                    ->execute();

            
            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            // recorremos la lista de mesas
            // y le insertamos la cuenta asociada
            $list_mesas = array();
            foreach ($result as $mesa) {

                $mesa->cuenta_id = $this->getCuentaByMesa($mesa->id);
                array_push($list_mesas, $mesa );
            }

            return $list_mesas;
        }

        /**
         * getCuentaByMesa
         *
         * retorna la cuenta activa asociada a una mesa
         *
         * @author Sebastián Silva
         * 
         * @param integer $mesa_id
         * @return integer
         */
        private function getCuentaByMesa($mesa_id) {

            if(!isset($mesa_id)){
                return 0;
            }

            $cuenta = Cuentas::find(array(
                "estado = 1 AND mesa_id = {$mesa_id} ",
                'order' => 'id desc'
            ));

            if(!$cuenta->count())
                return 0;

            $list_cuentas = array();

            foreach ($cuenta as $c) {
                array_push($list_cuentas, $c->id);    
            }
            return implode('-', $list_cuentas);
        }

        /**
        *
        * Obtiene pedidos pendientes de mesas de un funcionario
        *
        * @author osanmartin
        *
        * @param $param['funcionario_id'] : ID de funcionario
        * @return array con formato [$id_mesa] = $cantidad_pedidos
        *
        *
        */        

        public function getPedidosPendientesMesasFuncionario($param){

            if(!isset($param['funcionario_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $result = Pedidos::query()
                    ->columns(['mesa_id' => 'm.id','cantidad_pedidos'=>'count(App\Models\Pedidos.id)'])
                    ->leftJoin("App\Models\Cuentas","c.id = App\Models\Pedidos.cuenta_id","c")
                    ->leftJoin("App\Models\Mesas","m.id = c.mesa_id","m")
                    ->leftJoin("App\Models\FuncionarioMesa","m.id = fm.mesa_id","fm")
                    ->where("fm.funcionario_id = {$param['funcionario_id']}")
                    ->andWhere("fm.activo = {$this->ESTADO_MESA_ACTIVA}")
                    ->andWhere("App\Models\Pedidos.estado_id = {$this->ESTADO_PEDIDO_PENDIENTE}")
                    ->execute();


            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            $mesas = $this->getMesas($param);
            $pedidosPendientes = $result;

            foreach ($mesas as $val) {

                $arr[$val->id] = 0;

            }

            foreach ($pedidosPendientes as $key => $val) {

                if(isset($arr[$val->mesa_id]))
                    $arr[$val->mesa_id] = $val->cantidad_pedidos;

            }

            return $arr;

        }

        /**
        *
        * Obtiene pedidos totales de mesas de un funcionario
        *
        * @author osanmartin
        *
        * @param $param['funcionario_id'] : ID de funcionario
        * @return array con formato [$id_mesa] = $cantidad_pedidos
        *
        *
        */        

        public function getPedidosTotalesMesasFuncionario($param){

            if(!isset($param['funcionario_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $result = Pedidos::query()
                    ->columns(['mesa_id' => 'm.id','cantidad_pedidos'=>'count(App\Models\Pedidos.id)'])
                    ->leftJoin("App\Models\Cuentas","c.id = App\Models\Pedidos.cuenta_id","c")
                    ->leftJoin("App\Models\Mesas","m.id = c.mesa_id","m")
                    ->leftJoin("App\Models\FuncionarioMesa","m.id = fm.mesa_id","fm")
                    ->where("fm.funcionario_id = {$param['funcionario_id']}")
                    ->andWhere("fm.activo = {$this->ESTADO_MESA_ACTIVA}")
                    ->execute();


            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            $mesas = $this->getMesas($param);
            $pedidosTotales = $result;

            foreach ($mesas as $val) {

                $arr[$val->id] = 0;

            }

            foreach ($pedidosTotales as $key => $val) {

                if(isset($arr[$val->mesa_id]))
                    $arr[$val->mesa_id] = $val->cantidad_pedidos;

            }

            return $arr;

        }        
        
        /**
         * Obtiene las cuentas según el identificador de la mesa
         *
         * @author rsoto
         * @param $param = [ 
         *                    "mesa_id " => integer"             
         *                 ]
         * @return ResultSet
         */



        public function getDetalleMesa($param = null){


            if(isset($param)&&!empty($param)){


                if(isset($param['mesa_id'])){


                    $mesaId = $param['mesa_id'];
                    $cuentasPorMesa = Cuentas::query()
                        ->where(" mesa_id = {$mesaId} ")
                        ->execute();


                    if(!$cuentasPorMesa->count()){
                        $this->error = $this->errors->NO_RECORDS_FOUND;
                        return false;
                    }


                    return $cuentasPorMesa;
                }

            }else{
                    $this->error[] = $this->errors->MISSING_PARAMETERS;
                    return false;
            }

        }


        /**
         * Entrega un pedido 
         * Evalúa si es una promo, de serlo marca como entregados todos los productos
         * De la promoción
         *
         * @author rsoto
         * @param $param = [ 
         *                    "pedido_id " => integer"             
         *                 ]
         *
         * @return ResultSet
         */

        public function entregaPedido($param = null){

            if (isset($param['pedido_id']) AND !empty($param['pedido_id'])) {

                $pedidoId = $param['pedido_id'];
                $pedido = Pedidos::findFirstById($pedidoId);

                if($this->esPromo($param)){

                    return $this->entregaPedidoPromo(array('pedido_id' => $pedidoId));    

                }else{

                    $pedido->estado_id = 5;
                    if ($pedido->save() === false) {

                        $this->error = $this->errors->$FILE_WRITE_FAIL;
                        return false;
                    }else{
                        return true;
                    }
                }
            }else{
                $this->error = $this->errors->$MISSING_PARAMETERS;
                return false;

            }
        }
        

        /**
         * Entrega un producto en promocion param incluye [produc_promo_pedido].
         * Si param sólo trae [pedido_id], el método se encargará de marcar todos sus productos en promocion 
         * Como entregados 
         *
         * @author rsoto
         * @param $param = [ 
         *                    "pedido_id " => integer" 
         *                    "produc_promo_pedido_id " => integer"            
         *                 ]
         *
         * @return boolean
         */

        public function entregaPedidoPromo($param = null){

            if (isset($param['pedido_id']) AND !empty($param['pedido_id']) AND isset($param['produc_promo_pedido_id']) AND !empty($param['produc_promo_pedido_id'])) {

                $pedidoId = $param['pedido_id'];
                $productPromoId = $param['produc_promo_pedido_id'];
                $pedido = Pedidos::findFirstById($pedidoId);
                
                foreach ($pedido->ProducPromoPedidos as $productoPromo ) {
                   
                   if($productoPromo->id==$productPromoId){

                        $bandera = "a";
                        $productoPromo->estado = 5;
                        if ($productoPromo->save() === false) {
                           $this->error = $this->errors->$FILE_WRITE_FAIL;
                           return false;
                       }
                   }
                }
                if(!isset($bandera)){
                    $this->error = $this->errors->NO_RECORDS_FOUND;
                    return false;
                }

                return true;    

            }elseif(isset($param['pedido_id']) AND !empty($param['pedido_id'])){    

                if($this->esPromo($param)){

                    $pedidoId = $param['pedido_id'];
                    $pedido = Pedidos::findFirstById($pedidoId);

                    foreach ($pedido->ProducPromoPedidos as $productoPromo ) {

                        $productoPromo->estado = 5;
                        if ($productoPromo->save() === false) {
                           $this->error = $this->errors->$FILE_WRITE_FAIL;
                           return false;
                       }
                    }

                    return true;

                }else {
                    $this->error = $this->errors->WRONG_PARAMETERS;
                }

            }else{
                $this->error = $this->errors->$MISSING_PARAMETERS;
                return false;
            }

        }

        /**
         * Consulta si un pedido es promocion 
         *
         * @author rsoto
         * @param $param = [ 
         *                    "pedido_id " => integer" 
         *                    
         *                 ]
         *
         * @return boolean
         */
        private function esPromo($param){

            if(isset($param['pedido_id']) OR !empty($param['pedido_id'])){

                $pedidoId = $param['pedido_id'];
                $pedido = Pedidos::findFirstById($pedidoId);

                if(is_null($pedido->promocion_id)){
                    return false;
                }else{
                    return true;
                }
            }
        }

        /**
         * liberarMesas
         *
         * la cuenta pasará a estado cancelado
         * y se cancelaran los pedidos asociados
         */
        public function liberarMesas($param) {

            // verificamos que viene el id de la cuenta
            if( !isset($param['cuenta_id'])) {
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $this->db->begin();

            $cuenta = Cuentas::findFirstById($param['cuenta_id']);

            // verificamos que haya encontrado la cuenta
            if(!$cuenta) {
                $this->error = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            // cambiamos el estado de la cuanta a cancelado
            $cuenta->estado = $this->estado_cancelado;

            // verificamos que se actualice correctamente
            if($cuenta->save() == false ) {
                $this->error = $this->errors->$FILE_WRITE_FAIL;
                $this->db->rollback();
                return false;
            }


            $pedidos = Pedidos::findByCuentaId($param['cuenta_id']);

            if( $pedidos->count() > 0) {

                foreach ($pedidos as $pedido) {

                    $pedido->estado_id = $this->estado_cancelado;

                    if( !$pedido->save()) {

                        $this->db->rollback();
                        return false;
                    }
                }
            }


            $this->db->commit();
            return true;
        }


        /**
        *
        * Obtiene mesas para un funcionario
        *
        * @author osanmartin
        *
        * @return lista de objetos estados mesa asociados
        *
        */
        public function getEstadosMesa(){


            $result = EstadosMesa::find();

            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $result;

        }


        /**
        *
        * Obtiene cuentas para una mesa
        *
        * @author osanmartin
        *
        * @param $param['mesa_id'] = ID de mesa 
        *
        * @return array con formato [$cuenta_id] = ['subtotal'=>$subtotal,
        *                                           'cantidad'=>$cantidad]
        *
        */

        public function getDataCuentasByMesa($param){

            if(!isset($param['mesa_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;
            }

            $result = Cuentas::query()
                        ->columns(['cuenta_id' => 'App\Models\Cuentas.id',
                                   'subtotal'  => 'SUM(p.precio)',
                                   'cantidad'  => 'COUNT(p.id)'] )
                        ->leftJoin("App\Models\Mesas","App\Models\Cuentas.mesa_id = m.id","m")                        
                        ->leftJoin("App\Models\Pedidos","App\Models\Cuentas.id = p.cuenta_id","p")
                        ->where("m.id = {$param['mesa_id']}")
                        ->execute();

            if(!$result->count()) {
                return array();
            }

            $cuentas = $this->getDetalleMesa($param);

            if(!$cuentas) {
                return array();
            }

            foreach ($cuentas as $val) {
                
                $arr[$val->id] = ['subtotal'=>0,
                                  'cantidad'=>0,
                                  'cuenta'=>$val];

            }

            foreach ($result as $key => $val) {

                if(isset($arr[$val->cuenta_id]) AND 
                   $val->cantidad){

                    $arr[$val->cuenta_id]['subtotal'] = $val->subtotal;
                    $arr[$val->cuenta_id]['cantidad'] = $val->cantidad;
                }

            }

            return $arr;

        }

        /**
         * setNewClient
         * 
         * asigna un nuevo cliente a una mesa disponible
         * en caso de no haber una cuenta asociada se creara una
         *
         * @author  Sebastián Silva C
         *
         * @param   array $param nombre de usuario
         * @return  
         */
        public function setNewClient($param) {

            $this->db->begin();

            $cliente = new Clientes();

            $cliente->nombre            = $param['nombre'];
            $cliente->tipo_cliente_id   = 2;


            if($cliente->save() == false) {

                foreach ($cliente->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                $this->db->rollback();
                return false;
            }
            
            # em¡n caso de que no exista una cuenta la creamos para el cliente
            if( is_null($param['cuenta_id']) ) {

                $access = new AccessBSN();
    
                $cuenta = $access->initCuenta($cliente);

                if(!$cuenta) {

                    $this->error[] = $this->errors->WS_CONNECTION_FAIL;
                    $this->db->rollback();
                    return false;
                }

                $cuenta_id = $cuenta->id;
            } else {

                $cuenta_id = $param['cuenta_id'];
            }

            
            # seteamos la mesa a la cuenta
            $cuenta             = Cuentas::findFirstById($cuenta_id);
            $cuenta->mesa_id    = $param['table_id'];

            if( $cuenta->save() == false ) {

                $this->error[] = $this->errors->WS_CONNECTION_FAIL;
                $this->db->rollback();
                return false;
            }

            # cambiamos el estado de la mesa

            $mesa = Mesas::findFirstById($param['table_id']);

            $mesa->estado_mesa_id = $this->ESTADO_MESA_OCUPADA;

            if( $mesa->save() == false ) {

                $this->error[] = $this->errors->WS_CONNECTION_FAIL;
                $this->db->rollback();
                return false;
            }


            

            $this->db->commit();

            return true;
        }


    }

