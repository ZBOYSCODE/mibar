<?php


namespace App\Controllers;

use App\Business\CajaBSN;
use App\Business\ClienteBSN;
use App\Business\MeseroBSN;
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
                }

                $this->view->setVar('cuentas', $cuentas);

            } else {
                $this->view->setVar('cuentas', false);

            }

            $mesaObj = new MeseroBSN();

            $param = [
                "id" => $mesa_id
            ];

            $mesa = $mesaObj->getMesaPorId($param);

            $this->view->setVar('subtotales', $subtotales);
            $this->view->setVar('cantidadPedidos', $cantidadPedidos);
            $this->view->setVar('clientes', $clientes);
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

    public function pagarCuentaAction(){
        if ($this->request->isAjax()) {
            $this->mifaces->newFaces();
            if (isset($_POST["cuenta_id"])) {
                $dataView['productos'] = $this->cajaBsn->getProductosCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['subtotal'] = $this->cajaBsn->getSubTotalByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['cliente'] = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
                $dataView['cuenta'] = $this->formatearNumeroCuenta($_POST["cuenta_id"]);
                if ($dataView['productos'] == false
                    or $dataView['subtotal'] == false
                    or $dataView['cliente'] == false) {
                    $this->mifaces->addToMsg('warning', 'Error inesperado, reintente más tarde.');
                } else {
                    $view = "controllers/cashbox/pagar/modal";

                    $toRend = $this->view->getPartial($view, $dataView);

                    $this->mifaces->addToRend('modal_pagar_render',$toRend);
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
}