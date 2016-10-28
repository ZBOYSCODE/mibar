<?php
namespace App\Business;

use Phalcon\Mvc\User\Plugin;
use App\Models\Cuentas;
use App\Models\Pedidos;
/**
 * Modelo de negocio
 *
 * Acá se encuentra todo el modelo de negocios relacionado
 * a la caja.
 *
 * @author Zenta Group Viña del Mar
 */
DEFINE('POR_PAGAR', '1');
class CajaBSN extends Plugin
{
    /**
     *
     * @var array
     */
    public 	$error;

    /**
     * Trae la lista de cuentas por pagar dada una mesa
     *
     * @author jcocina
     * @param array 'mesa_id' int
     * @return lista Cuentas
     */
    public function getListaCuentasPorPagar($param) {
        if (!isset($param['mesa_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }

        $result = Cuentas::find(
            "estado = '" . POR_PAGAR . "' and mesa_id = " . $param['mesa_id']
        );

        if(!$result->count()) {
            $this->error[] = $this->errors->NO_RECORDS_FOUND;
            return false;
        }

        return $result;
    }

    /**
     * Trae el valor del subtotal de una cuenta
     *
     * @author jcocina
     * @param array 'cuenta_id' int
     * @return int subtotal
     */
    public function getSubTotalByCuenta($param) {
        if (!isset($param['cuenta_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }
        $result = 0;
        $pedidos = Pedidos::find("estado_id <> 5 and cuenta_id = " . $param['cuenta_id']);
        foreach ($pedidos as $var) {
            $result = $result + $var->precio;
        }
        return $result;
    }

    /**
     * Trae la cantidad de pedidos por pagar de una cuentas
     *
     * @author jcocina
     * @param array 'cuenta_id' int
     * @return int subtotal
     */
    public function getCantidadPedidoByCuenta($param) {
        if (!isset($param['cuenta_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }
        $result = 0;
        $pedidos = Pedidos::find("estado_id <> 5 and cuenta_id = " . $param['cuenta_id']);
        return $pedidos->count();
    }


}