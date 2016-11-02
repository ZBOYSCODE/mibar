<?php


namespace App\Controllers;

use App\Business\CajaBSN;
use App\Models\Clientes;
use App\Models\Mesas;

class CashBoxController extends ControllerBase
{
    private $cajaBsn;

    public function initialize()
    {

        parent::initialize();
        $this->cajaBsn = new CajaBSN();
    }

    public function indexAction() {

        $mesas = Mesas::find();





        $this->view->setVar('mesas', $mesas);
        $this->view->pick('controllers/cashbox/_index');

    }

    public function tableAction($mesa_id = null){


        #js custom
        $this->assets->addJs('js/pages/cashbox.js');


        if($mesa_id == null or !is_numeric($mesa_id)) {
            $this->contextRedirect('cashbox');
        }


        $cuentas = $this->cajaBsn->getListaCuentasPorPagar(array('mesa_id' => $mesa_id));
        if($cuentas) {

            foreach ($cuentas as $var) {
                $param = array('cuenta_id' => $var->id);
                $subtotales[$var->id] = number_format($this->cajaBsn->getSubTotalByCuenta($param), 0, ',', '.');
                $cantidadPedidos[$var->id] = $this->cajaBsn->getCantidadPedidoByCuenta($param);
                $clientes[$var->id] = Clientes::findFirstById($var->cliente_id);
            }

            $this->view->setVar('cuentas', $cuentas);

        } else {
            $this->view->setVar('cuentas', false);
        }

        $this->view->setVar('subtotales', $subtotales);
        $this->view->setVar('cantidadPedidos', $cantidadPedidos);
        $this->view->setVar('clientes', $clientes);
        $this->view->pick('controllers/cashbox/_index');
    }

    public function detallepedidosAction() {
        if ($this->request->isAjax()) {

            $items = $this->cajaBsn->getProductosDetallesByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
            $dataView['cliente'] = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));

            $dataView['productos'] = $items["productos"];
            $dataView['cantidad'] = $items["cantidad"];


            $view = "controllers/cashbox/detalles_pedidos/modal";



            $this->mifaces->newFaces();

            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('modal_cuenta_render',$toRend);
            $this->mifaces->run();
        }
        else {
            $this->view->disable();
        }
    }
}