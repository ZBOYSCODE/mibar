<?php
/**
 * Created by PhpStorm.
 * User: Jorge Cociña
 * Date: 03-11-2016
 * Time: 9:40
 */

namespace App\Business;
use Phalcon\Mvc\User\Plugin;
use App\Models\Clientes;

/**
 * Modelo de negocio
 *
 * Acá se encuentra todo el modelo de negocios relacionado
 * a los clientes.
 *
 * @author Zenta Group Viña del Mar
 */
class ClienteBSN extends Plugin
{
    public 	$error;


    /**
     * Retorna un cliente según el id
     *
     * @autor jcocina
     * @param $param array id  id de cliente
     * @return bool | objeto cliente
     */
    public function getClienteById($param) {
        if (!isset($param['id']) || $param['id'] == null) {
            $this->error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }
        $result = Clientes::findFirstById($param['id']);
        if (!$result->count()) {
            $this->error[] = $this->errors->NO_RECORDS_FOUND;
            return false;
        }
        return $result;
    }
}