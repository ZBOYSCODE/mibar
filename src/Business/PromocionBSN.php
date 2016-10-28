<?php
    /**
     * Modelo de negocio PedidoBSN
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * a la creación de promociones
     *
     * @package      MiBar
     * @subpackage   Promocion Business
     * @category     Promociones y relacionados
     * @author       Zenta Group Viña del Mar
     */


    namespace App\Business;
    
    use Phalcon\Mvc\User\Plugin;
    use App\Models\Pedidos;
    use App\Models\ProducPromoPedidos;
    use App\Models\Promociones;
    use App\Models\TipoPromo;
    
    /**
     * Modelo de negocio
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * a los pedidos.
     *
     * @author Zenta Group Viña del Mar
     */
    class PromocionBSN extends Plugin
    {
        /**
         *
         * @var array
         */
    	public 	$error;


        /**
         * getPromocion
         *
         * @author osanmartin
         * @param $param['promocion_id'] = ID de promocion
         * @return objeto Promocion
         */
        public function getPromocion($param){

            if(!isset($param['promocion_id'])){
                $this->error[] = $this->errors->MISSING_PARAMETERS;
            }

            if(isset($param['promocion_id']))
                $result = Promociones::findFirstById($param['promocion_id']);

            if(!$result->count()){
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $result;

        }

        /**
         * getTipoPromo
         *
         *  retorna los tipos de promociones
         *
         * @author Sebastián Silva
         * @return object
         */
        public function getListTipoPromo() {

            $tipopromo = TipoPromo::find();

            if($tipopromo->count() == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $tipopromo;

        }

        /**
         * getPromociones
         *
         * retorna la lista de todas las promociones
         *
         * @author Sebastián Silva
         *
         * @param array $param
         * @return object 
         */
        public function getPromociones($param = null) {

            if(!empty($param['tipo_promo_id'])) {

                $promociones = Promociones::findByTipoPromoId($param['tipo_promo_id']);

            } else { 

                $promociones = Promociones::find();

            }

            

            if($promociones->count() == 0) {
                $this->error[] = $this->errors->NO_RECORDS_FOUND;
                return false;
            }

            return $promociones;

        }


         /**
         * getPreciosPromocion
         *
         * retorna la lista de los precios
         *
         * @author osanmartin
         *
         * @param array $param : array de promociones u objetos
         *                        con el siguiente formato:
         *                          ["es_promocion" => boolean,
         *                           "producto_id" => integer];
         * @return array [id => precio]
         */

        public function getPreciosPromocion($param){

            $list = array();

            if( count($param) == 0 ){
                return array();
            }

            foreach ($param as $val) {
            
                if( $val["es_promocion"] ){

                    array_push($list, $val["producto_id"] );
                }
            }


            if( count($list) > 0 ) {

                $list = implode(',', $list);

                $find = "id IN (".$list.")";


                $promociones = Promociones::find($find);

                if(!$promociones->count()) {

                    return array();

                } else {
                    
                    $arr = array();
                    
                    foreach ($promociones as $promocion) {

                        $arr[$promocion->id] = $promocion;
                    }
                }

                return $arr;
            
            } else {

                return array();
            }
                

        }   


        /**
         * getPrecioById
         * funcion corta
         * @author Sebastián Silva 
         * @param $id identificador producto 
         */   
        public function getPrecioById($id) {

            $producto = Promociones::findFirstById($id);

            if(!$producto) {
                return 0;
            } else {
                return $producto->precio;
            }
        }        


    }
