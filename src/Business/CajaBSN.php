<?php
namespace App\Business;

use App\Models\Clientes;
use Phalcon\Mvc\User\Plugin;
use App\Models\Cuentas;
use App\Models\Pedidos;
use App\Models\Pagos;


DEFINE('ACTIVA', '1');
DEFINE('PEDIDO_CANCELADO', 6);

/**
 * Modelo de negocio
 *
 * Acá se encuentra todo el modelo de negocios relacionado
 * a la caja.
 *
 * @author Zenta Group Viña del Mar
 */
class CajaBSN extends Plugin
{
    /**
     *
     * @var array
     */
    public 	$error;
    private $pedidosBSN;

    public function __construct()
    {
        $this->pedidosBSN = new PedidoBSN();
    }
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
            "estado = '" . ACTIVA . "' and mesa_id = " . $param['mesa_id']
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
        $pedidos = Pedidos::find("  pago_id is null 
                                AND estado_id != ".PEDIDO_CANCELADO."
                                AND cuenta_id = " . $param['cuenta_id']);

        if($pedidos->count()) {
            foreach ($pedidos as $var) {
                $result = $result + $var->precio;
            }
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

        $pedidos = Pedidos::find("  pago_id is null 
                                AND estado_id != ".PEDIDO_CANCELADO."
                                AND cuenta_id = " . $param['cuenta_id']);

        return $pedidos->count();
    }

    /**
     * @param $param
     * @return array    ['cantidad'][idProducto] cantidad que se pidio del producto
     *                  ['productos'] lista de productos
     */
    public function getProductosDetallesByCuenta($param) {
        if (!isset($param['cuenta_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }

        $productos = $this->pedidosBSN->getProductosByCuenta($param);
        if(!$productos) {
            $this->error[] = $this->errors->NO_RECORDS_FOUND;
            return false;
        }
        $lista = array();
        foreach ($productos as $producto) {
            $class = get_class($producto);
            $class = explode('\\', $class);
            $class = $class[sizeof($class)-1];
            if (isset($result['cant'.$class][$producto->id])) {
                $result['cant'.$class][$producto->id] = $result['cant'.$class][$producto->id] + 1;
                $result['total'.$class][$producto->id] = $producto->precio + $result['total'.$class][$producto->id];
            } else {
                $result['cant'.$class][$producto->id] = 1;
                $result[strtolower($class)][] = $producto;
                $result['total'.$class][$producto->id] = $producto->precio;
            }
        }
        if(!isset($result['productos'])) {
            $result['productos'] = array();
            $result['cantProductos'] = array();
            $result['totalProductos'] = array();
        }
        if(!isset($result['promociones'])) {
            $result['promociones'] = array();
            $result['cantPromociones'] = array();
            $result['totalPromociones'] = array();
        }

        return $result;
    }

    /**
     * @author jcocina
     * @param $param array 'cuenta_id'
     * @return objeto cliente
     */
    public function getClienteByCuenta($param) {
        if (!isset($param['cuenta_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }


        $cuenta = Cuentas::findFirstById($param['cuenta_id']);
        $cliente = Clientes::findFirstById($cuenta->cliente_id);

        if(!$cliente->count()) {
            $error[] = $this->errors->NOT_RECORDS_FOUND;
            return false;
        }

        return $cliente;
    }

    /**
     *
     * Obtiene una cuenta por su id.
     *
     *
     * @author osanmartin
     * @param array $param['cuenta_id'] 
     * @return objeto Cuenta
     *
     *
     */

    public function getCuentaById($param){

        if(!isset($param['cuenta_id'])){

            $this->error[] = $this->errors->MISSING_PARAMETERS;
            return false;

        }

        $result = Cuentas::findFirstById($param['cuenta_id']);

        if(!$result->count()){

            $this->error[] = $this->errors->NO_RECORDS_FOUND;

        }

        return $result;
    }

    /**
     * Trae la lista de productos asociados a una cuenta
     * @param $param 'cuenta_id'
     * @return array|bool Lista de objetos productos
     */
    public function getProductosCuenta($param) {
        if (!isset($param['cuenta_id'])) {
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }

        $productos = $this->pedidosBSN->getProductosByCuenta($param);
        if(!$productos) {
            $this->error[] = $this->errors->NO_RECORDS_FOUND;
            return false;
        }
        return $productos;
    }


    /**
     * realizarPago
     *
     * persiste el pago y actualiza los pedidos
     *
     * @author Sebastián Silva
     *
     * @param array $param
     */
    public function realizarPago($param) {

        if (!isset($param['cuenta_id'])) {
            # verificamos cuenta
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }


        if (!isset($param['descuento'])) {
            # verificamos descuento
            $error[] = $this->errors->MISSING_PARAMETERS;
            return false;
        }


        $subtotal = $this->getSubTotalByCuenta(array('cuenta_id'=> $param['cuenta_id']));
        $subtotal_wdesc = ( $subtotal - (int)$param['descuento'] );

        
        $this->db->begin();


        $pago = new Pagos();

        $pago->fecha            = date('Y-m-d H:i:s');
        $pago->medio_pago       = "Efectivo";
        $pago->funcionario_id   = 1;//$this->session->get("auth-identity")['id'];
        $pago->subtotal         = $subtotal;
        $pago->total            = $subtotal_wdesc;




        # Guardamos los datos del pago
        if( $pago->save() == false ) {

            $this->db->rollback();
            
            $messages = $pago->getMessages();

            foreach ($messages as $message) {
                $this->error[] = $message;
            }

            return false;
        }

        $pedidosBsn = new PedidoBSN();

        $arr = array(
            'cuenta_id' => $param['cuenta_id'],

        );


        if ( $this->session->has('pedidos_to_pay') ) {

            //$pedidos = $pedidosBsn->getOrdersWithoutPayment($param);

            $list = $this->session->get('pedidos_to_pay');



            $pedidos = Pedidos::find(" id in ({$list}) ");

        } else {

            $this->db->rollback();
            $this->error[] = $this->errors->UNKNOW;
            return false;
        }

        

        if( $pedidos == false ) {

            $this->db->rollback();
            $this->error[] = $this->errors->UNKNOW;
            return false;
        }


        foreach ($pedidos as $pedido) {
            
            $pedido->pago_id = $pago->id;

            // al pagar cambia automaticamente a en proceso, 
            // es decir que no hace falta la validación por parte del mesero
            if( $pedido->estado_id == 1 ) {
                $pedido->estado_id = 2;
            }

            if( $pedido->save() == false ) {

                $this->db->rollback();

                $messages = $pedido->getMessages();

                foreach ($messages as $message) {
                    $this->error[] = $message;
                }

                return false;
            }

        }

        $this->session->remove('pedidos_to_pay');

        $this->db->commit();
        return true;
    }
}













































