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
        $this->cajaBsn = new CajaBSN();
    }

    public function indexAction() {
        $mesas = Mesas::find();
        $this->view->setVar('mesas', $mesas);

        $this->view->pick('controllers/cashbox/_index');
    }

    public function TableAction($mesa_id = null){

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
            $this->view->setVar('subtotales', $subtotales);
            $this->view->setVar('cantidadPedidos', $cantidadPedidos);
            $this->view->setVar('clientes', $clientes);
            $this->view->pick('controllers/cashbox/table');
        } else {
            //TO DO
        }
    }

    public function DetallePedidosAction() {
        if ($this->request->isAjax()) {

            $dataView = $this->cajaBsn->getProductosDetallesByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
            $dateView['cliente'] = $this->cajaBsn->getClienteByCuenta(array('cuenta_id' => $_POST["cuenta_id"]));
            $view = "controllers/cashbox/detalles_pedidos/modal";
            $this->mifaces->newFaces();

            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('orders-modal',$toRend);
            $this->mifaces->run();
        }
        else {
            $this->view->disable();
        }
    }
}