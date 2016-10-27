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
    use App\Models\Mesas;
    use App\Models\FuncionarioMesa;
    use App\Models\Cuentas;
    use App\Models\Pedidos;
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

        public $estado_cancelado = 6;

        /**
         * Obtiene mesas según parametro (Todas las mesas de un bar o todas las mesas asignadas a un mesero)
         * En TestController es posible getCuentaAction, es posible encontrar la forma de acceder a sus valores 
         *
         * @author rsoto
         * @param $param = [ 
         *                    "funcionario_id" => integer
         *                     "turno_id"       => integer
         *                    "fecha"          => Date

         *                 ]
         * @return boolean
         */

        public function getMesas($param = null){

            if(isset($param)&&!empty($param)){
                
                if( isset($param['funcionario_id']) AND 
                    isset($param['turno_id']) AND 
                    isset($param['fecha'])) {
                

                    $funcionario_id = $param['funcionario_id'];
                    $turno_id       = $param['turno_id'];
                    $fecha          = $param['fecha'];

                    $fechaY         = $fecha->format('Y');
                    $fechaM         = $fecha->format('m');
                    $fechaD         = $fecha->format('d');

                    $mesas = FuncionarioMesa::query()
                        ->where("funcionario_id         = {$funcionario_id}")
                        ->andWhere("turno_id            = {$turno_id}")
                        ->andWhere("YEAR(fecha) = {$fechaY}")
                        ->andWhere("MONTH(fecha) = {$fechaM}")
                        ->andWhere("DAY(fecha)   = {$fechaD}")
                        ->execute();

                    if(!$mesas->count()){
                        $this->error = $this->errors->NO_RECORDS_FOUND;
                        return false;
                    }
                    return $mesas;

                }
            

                if(isset($param['bar_id'])){

                    $barId  = $param['bar_id'];

                    $mesas = Mesas::query()
                        ->where(" bar_id = {$barId}")
                        ->execute();

                    if(!$mesas->count()){
                        $this->error = $this->errors->NO_RECORDS_FOUND;
                        return false;
                    }
                    return $mesas;
                }else{

                    $this->error[] = $this->errors->MISSING_PARAMETERS;
                    return false;

                }

            }else{
                $this->error[] = $this->errors->MISSING_PARAMETERS;
                return false;

            }
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

    }

