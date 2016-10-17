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

    }
