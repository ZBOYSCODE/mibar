<?php


namespace App\Controllers;

use App\Business\CajaBSN;
use App\Models\Clientes;
use App\Models\Mesas;

class CashBoxController extends ControllerBase
{
    private $cajaBsn;


    public function indexAction() {
        $mesas = Mesas::find();
        $this->view->setVar('mesas', $mesas);

        $this->view->pick('controllers/cashbox/_index');
    }

    public function TableAction($mesa_id = null){
        $cajaBsn = new CajaBSN();
        if($mesa_id == null or !is_numeric($mesa_id)) {
            $this->contextRedirect('cashbox');
        }
        $cuentas = $cajaBsn->getListaCuentasPorPagar(array('mesa_id' => $mesa_id));
        if($cuentas) {

            foreach ($cuentas as $var) {
                $param = array('cuenta_id' => $var->id);
                $subtotales[$var->id] = number_format($cajaBsn->getSubTotalByCuenta($param), 0, ',', '.');
                $cantidadPedidos[$var->id] = $cajaBsn->getCantidadPedidoByCuenta($param);
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


}