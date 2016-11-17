<?php


namespace App\Controllers;

use App\Business\CajaBSN;
use App\Business\ClienteBSN;
use App\Business\MeseroBSN;
use App\Business\PedidoBSN;

use App\library\Constants\Constant;


class CashBoxController extends ControllerBase
{
    private $cajaBsn;

    private $clienteBsn;

    private $constant;

    /**
     * initialize
     *
     * @author Jorge Silva
     *
     * inicializa la clase
     */

    public function initialize()
    {

        parent::initialize();
        $this->cajaBsn = new CajaBSN();
        $this->clienteBsn = new ClienteBSN();
        $this->constant = new Constant();
        $this->pedidosBsn = new PedidoBSN();
        $this->meseroBsn = new MeseroBSN();
    }


    /**
     * indexAction
     *
     * @author Jorge Silva
     *
     * Muestra la lista mesas que estan con cuentas activas
     * metodo de tipo get
     *
     */
    public function indexAction() {

        #js custom
        $this->assets->addJs('js/pages/cashbox.js');


        $meseroBsn = new MeseroBSN();

        #traemos el estado de mesa ocupada
        $paramStatus = [
            "name" => $this->constant->ESTADO_MESA_OCUPADA
        ];

        $status = $meseroBsn->getEstadosMesaPorNombre($paramStatus);


        #traemos las mesas por estado ocupado (las que tienen cuentas)
        $param = [
            "estado_mesa_id" => $status->id
        ];

        $mesas = $meseroBsn->getMesasPorEstado($param);

        $this->view->setVar('mesas', $mesas);
        $this->view->pick('controllers/cashbox/_index_tables');
    }


    public function tableAction($mesa_id){
        #js custom
        $this->assets->addJs('js/pages/cashbox.js');
        if(!isset($mesa_id)) {
            $mesa_id = null;
        }
        if($mesa_id != null and is_numeric($mesa_id)) {


            $cuentas = $this->cajaBsn->getListaCuentasPorPagar(array('mesa_id' => $mesa_id));

            if ($cuentas) {
                foreach ($cuentas as $var) {

                    $param = array('cuenta_id' => $var->id);
                    $subtotales[$var->id] = number_format($this->cajaBsn->getSubTotalByCuenta($param), 0, ',', '.');
                    $cantidadPedidos[$var->id] = $this->cajaBsn->getCantidadPedidoByCuenta($param);
                    $clientes[$var->id] = $this->clienteBsn->getClienteById(array('id' => $var->cliente_id));

                    if(!$clientes[$var->id]){
                        $cuentas = false;
                        break;
                    }

                    if(!$subtotales[$var->id]){
                        $subtotales[$var->id] = 0;
                    }
                    if (!$cantidadPedidos[$var->id]) {
                        $cantidadPedidos[$var->id] = 0;
                    }

                    $bills[$var->id] = $var;
                }

                $hasCuentas = true;

            } else {

                $hasCuentas = false;

            }

            $mesaObj = new MeseroBSN();

            $param = [
                "id" => $mesa_id
            ];

            $mesa = $mesaObj->getMesaPorId($param);


            // Ordenar subtotales de mayor a menor.
            arsort($subtotales);

            // Se ordenan y agrupan los demás campos, en base a los subtotales.
            foreach ($subtotales as $key => $val) {

                $cuentasGroup[$key] = [  'subtotal' => $val, 
                                    'cliente'  => $clientes[$key],
                                    'cantidadPedidos' => $cantidadPedidos[$key],
                                    'cuenta' => $bills[$key]];

            }

            if($hasCuentas)
                $this->view->setVar('cuentasGroup',$cuentasGroup);
            else 
                $this->view->setVar('cuentasGroup',false);

            $this->view->setVar('mesa', $mesa);
            $this->view->pick('controllers/cashbox/_index');
        } else {
            $this->contextRedirect('cashbox');
        }
    }

    public function detallepedidosAction() {
        if ($this->request->isAjax()) {
            $this->mifaces->newFaces();
            if (isset($_POST["cuenta_id"])) {
                $items = $this->cajaBsn->getProductosDetallesByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $cliente = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['total'] = $this->cajaBsn->getSubTotalByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['cliente'] = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                if($items == false
                    || $cliente == false
                    || $dataView['total'] == false
                    || $dataView['cliente'] == false) {
                    $this->mifaces->addToMsg('warning', 'Error inesperado, reintente más tarde.');
                }
                else {
                    $dataView['total'] = number_format($dataView['total'], 0, ',', '.');
                    $dataView['productos'] = $items["productos"];
                    $dataView['cantProductos'] = $items["cantProductos"];
                    $dataView['promociones'] = $items["promociones"];
                    $dataView['cantPromociones'] = $items["cantPromociones"];
                    $dataView['totalProductos'] = $items['totalProductos'];
                    $dataView['totalPromociones'] = $items['totalPromociones'];
                    $dataView['cliente'] = $cliente;
                    $view = "controllers/cashbox/detalles_pedidos/modal";

                    $toRend = $this->view->getPartial($view, $dataView);

                    $this->mifaces->addToRend('modal_cuenta_render',$toRend);

                }
            }
            else {
                $this->mifaces->addToMsg('warning', 'Faltan parámetros.');
            }
            $this->mifaces->run();
        }
        else {
            $this->view->disable();
        }
    }



    public function pagarCuentaAction() {

        if ($this->request->isAjax()) {
            $this->mifaces->newFaces();
            
            if (isset($_POST["cuenta_id"])) {
            
                $dataView['productos']  = $this->cajaBsn->getProductosCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['subtotal']   = $this->cajaBsn->getSubTotalByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['cliente']    = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['cuenta']     = $this->formatearNumeroCuenta($_POST["cuenta_id"]);

                $meseroBsn = new MeseroBSN();

                $dataView['mesa']       = $meseroBsn->getTableByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));


                $dataView['cuenta_id'] = $_POST["cuenta_id"];

                if ($dataView['productos'] == false
                    or $dataView['subtotal'] == false
                    or $dataView['cliente'] == false) {





                    $this->mifaces->addToMsg('warning', 'Error inesperado, reintente más tarde.');





                } else {

                    if ( $this->savePedidosToPay( $_POST["cuenta_id"] ) ) {

                        $view = "controllers/cashbox/pagar/modal";
                        $toRend = $this->view->getPartial($view, $dataView);
                        $this->mifaces->addToRend('modal_pagar_render',$toRend);

                    } else {

                        $this->mifaces->addToMsg('warning', 'Error inesperado, reintente más tarde.');
                    }               
                    
                }
            }
            else {
                $this->mifaces->addToMsg('warning', 'Faltan parámetros.');
            }

            $this->mifaces->run();
        }
        else {
 
            $this->view->disable();
        }
    }

    private function formatearNumeroCuenta($cuenta_id) {
        while (strlen($cuenta_id) <= 10) {
            $cuenta_id = '0' . $cuenta_id;
        }
        return $cuenta_id;
    }

    /**
     * savePedidosToPay
     *
     * tiene como finalidad guardar en sesion, los pedidos que se pagaran
     * la idea es pagar solamente los que aparecen en la lista y no otros que se podrían pedir
     * en el momento de "estar pagando".
     *
     * @author Sebastián Silva
     * @param integer $cuenta_id identificador de la cuenta
     */
    private function savePedidosToPay($cuenta_id) {

        $param = array(
            'cuenta_id' => $cuenta_id
        );


        $pedidos = $this->pedidosBsn->getOrdersWithoutPayment($param);
       
        if ($this->session->has('pedidos_to_pay')) {

            $this->session->remove('pedidos_to_pay');
        }


        $arr = array();

        if($pedidos != false) {

            foreach ($pedidos as $pedido) {
                array_push($arr, $pedido->id);
            }
        }


        $arr = implode(',', $arr);

        $this->session->set('pedidos_to_pay', $arr);

        return true;
    }

    /**
     * completarPagoAction
     *
     * @author Sebastián Silva
     */
    public function completarPagoAction(){

        if ($this->request->isAjax()) {
        
            $this->mifaces->newFaces();
        
            if (isset($_POST["cuenta_id"]) and isset($_POST["descuento"])) {

                $cuenta_id = $this->request->getPost("cuenta_id", "int");
                $descuento = $this->request->getPost("descuento", "int");

                $subtotal   = $this->cajaBsn->getSubTotalByCuenta( array('cuenta_id' => $cuenta_id ));

                $descuento  = trim ( str_replace('.', '', $descuento ) ) ;


                if ( $descuento < 0 ) {
                    # verificamos que el descuento sea mayor a 0
                    $this->mifaces->addToMsg('warning', 'Por favor verificar el descuento.');
                    $this->mifaces->run();
                    return false; 
                }

                if ( $descuento > $subtotal ) {
                    # verificamos que el descuento no sea mayor al subtotal
                    $this->mifaces->addToMsg('warning', 'El descuento no puede ser mayor al subtotal.');
                    $this->mifaces->run();
                    return false; 
                }

                $param = array(
                    'cuenta_id' => $cuenta_id,
                    'subtotal'  => $subtotal,
                    'descuento' => $descuento
                );


                $result = $this->cajaBsn->realizarPago($param);


                if ( $result !== false ){



                    $mesa = $this->meseroBsn->getTableByCuenta(['cuenta_id' => $cuenta_id]);
                    $mesa_id = $mesa->id;


                    $cuentas = $this->cajaBsn->getListaCuentasPorPagar(array('mesa_id' => $mesa_id));

                    if ($cuentas) {
                        foreach ($cuentas as $var) {
                            $param = array('cuenta_id' => $var->id);
                            $subtotales[$var->id] = number_format($this->cajaBsn->getSubTotalByCuenta($param), 0, ',', '.');
                            $cantidadPedidos[$var->id] = $this->cajaBsn->getCantidadPedidoByCuenta($param);
                            $clientes[$var->id] = $this->clienteBsn->getClienteById(array('id' => $var->cliente_id));

                            if(!$clientes[$var->id]){
                                $cuentas = false;
                                break;
                            }
                            if(!$subtotales[$var->id]){
                                $subtotales[$var->id] = 0;
                            }
                            if (!$cantidadPedidos[$var->id]) {
                                $cantidadPedidos[$var->id] = 0;
                            }
                        }

                        //$this->view->setVar('cuentas', $cuentas);
                        $dataView['cuentas']    = $cuentas;


                         // Ordenar subtotales de mayor a menor.
                        arsort($subtotales);

                        // Se ordenan y agrupan los demás campos, en base a los subtotales.
                        foreach ($subtotales as $key => $val) {

                            $cuentasGroup[$key] = [  'subtotal' => $val, 
                                                'cliente'  => $clientes[$key],
                                                'cantidadPedidos' => $cantidadPedidos[$key],
                                                'cuenta' => $bills[$key]];

                        }

                    } else {
                        $dataView['cuentas']    = false;
                        //$this->view->setVar('cuentas', false);

                    }




                    if($dataView['cuentas'])
                        $dataView['cuentasGroup']         = $cuentasGroup;
                    else 
                        $dataView['cuentasGroup']         = false;
                    

                    $dataView['subtotales']         = $subtotales;
                    $dataView['cantidadPedidos']    = $cantidadPedidos;
                    $dataView['clientes']           = $clientes;
                    $dataView['mesa']               = $mesa;


                    $view = "controllers/cashbox/table/_index";

                    $toRend = $this->view->getPartial($view, $dataView);

                    $this->mifaces->addToRend('tables-content-parent',$toRend);
                    $this->mifaces->addToMsg('success', 'Pagado con exito.');



                } else {

                    $this->mifaces->addToMsg('warning', 'Error al realizar pago.');    
                }

                
            }
            else {
                $this->mifaces->addToMsg('warning', 'Faltan parámetros.');
            }

            $this->mifaces->run();
        }
        else {
            $this->view->disable();
        }
    }

    /**
     * updescuentoAction
     *
     * @author Sebastián Silva
     */
    public function updescuentoAction() {

        if ($this->request->isAjax()) {

            $this->mifaces->newFaces();
            
            if (isset($_POST["cuenta_id"]) and isset($_POST["descuento"])) {

                $subtotal   = $this->cajaBsn->getSubTotalByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $descuento = str_replace('.', '', $_POST['descuento']);

                $total = $subtotal - $descuento;

                $total = number_format($total, 0, ',', '.');

                $this->mifaces->addToDataView('total', $total );

                $this->mifaces->run();
            }
            else {
                $this->mifaces->addToMsg('warning', 'Faltan parámetros.');
            }
        }
        else {
            $this->view->disable();
        }

    }
}




















