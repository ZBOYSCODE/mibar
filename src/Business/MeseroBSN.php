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

    

    }

