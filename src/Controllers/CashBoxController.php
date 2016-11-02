<?php


namespace App\Controllers;

use App\Business\CajaBSN;
use App\Business\MeseroBSN;
use App\library\Constants\Constant;
use App\Models\Clientes;

class CashBoxController extends ControllerBase
{
    private $cajaBsn;
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

        if(!isset($mesa_id)){
            $mesa_id = null;
        }

        #js custom
        $this->assets->addJs('js/pages/cashbox.js');


        if($mesa_id != null and is_numeric($mesa_id)) {

            $cuentas = $this->cajaBsn->getListaCuentasPorPagar(array('mesa_id' => $mesa_id));
            if ($cuentas) {

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
        }
        else{
            $this->contextRedirect("cashbox");
        }
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