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
         * Obtiene mesas según parametro (Todas o por mesero)
         *
         * @author rsoto
         * @param $param = [ 
         *                    "funcionario_id" => integer
                              "turno_id"       => integer
                              "fecha"          => Date
         *                 ]
         * @return boolean
         */

        public function getMesas($param = null){

            if(isset($param)&&!empty($param)){
                
                if( !isset($param['funcionario_id']) OR 
                    !isset($param['turno_id']) OR 
                    !isset($param['fecha'])
                )
                {
                    $this->error[] = $this->errors->MISSING_PARAMETERS;
                    return false;
                }

                $funcionario_id = $param['funcionario_id'];
                $turno_id       = $param['turno_id'];
                $fecha          = $param['fecha'];

                $fechaY         = $fecha->format('Y');
                $fechaM         = $fecha->format('m');
                $fechaD         = $fecha->format('d');


                $mesas = FuncionarioMesa::query()
                    //->leftJoin('App\Models\Mesas', 'App\Models\FuncionarioMesa.mesa_id = Mesa.id',  'Mesa')
                    ->where("funcionario_id         = {$funcionario_id}")
                    ->andWhere("turno_id            = {$turno_id}")
                    ->andWhere("YEAR(fecha) = {$fechaY}")
                    ->andWhere("MONTH(fecha) = {$fechaM}")
                    ->andWhere("DAY(fecha)   = {$fechaD}")
                    //->order("Mesa.numero")
                    ->execute();

                if(!$mesas->count()){
                    $this->error = $this->errors->NO_RECORDS_FOUND;
                    return false;
                }

                return $mesas;

            }


            if(!isset($param)){

                $mesas = Mesas::find();

                if(!$mesas->count()){

                    $this->error = $this->errors->NO_RECORDS_FOUND;

                    return false;

                }

                return $mesas;

            }






        }
        








    }



















