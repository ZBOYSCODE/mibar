<?php

namespace App\Controllers;

use App\Business\AccessBSN;
use App\Business\MeseroBSN;
use App\Business\PedidoBSN;
use App\Business\CajaBSN;
use App\library\Constants\Constant;


use App\Business\ProductoBSN;
use App\Business\PromocionBSN;

class WaiterController extends ControllerBase
{

    // Business

    private $meseroBsn;
    private $pedidoBsn;
    private $cajaBsn;
    private $constant;

    private $ID_CATEGORY_BEBIDAS = 1;
    private $ID_CATEGORY_COMIDAS = 2;

    public function initialize(){

        parent::initialize();
        $this->meseroBsn = new MeseroBSN();
        $this->pedidoBsn = new PedidoBSN();
        $this->cajaBsn   = new CajaBSN();
        $this->constant = new Constant();

        $this->productoBsn = new ProductoBSN();
        $this->promocionBsn = new PromocionBSN();

    }    


    /**
    * Index
    *
    *
    * @author osanmartin
    *
    * Carga lista de mesas para un mesero determinado.
    *
    */
    public function indexAction()
    {
        //DATO EN BRUTO
        $id_mesero = 1;

    	#js custom
        $this->assets->addJs('js/pages/waiter.js');

        $datetime = new \DateTime('now');

        $paramMesas = ['funcionario_id' => $id_mesero, 
                       'fecha' => $datetime->format('Y-m-d'),
                       'turno' => $datetime->format('H:i:s')];

        $mesas      = $this->meseroBsn->getMesas($paramMesas);

        $estadosMesa        = $this->meseroBsn->getEstadosMesa();
        $pedidosPendientes  = $this->meseroBsn->getPedidosPendientesMesasFuncionario($paramMesas);
        $pedidosTotales     = $this->meseroBsn->getPedidosTotalesMesasFuncionario($paramMesas);

        if(!$mesas)
            $mesas = array();

        #vista
        $this->view->setVar("mesas",$mesas) ;
        $this->view->setVar("pedidosPendientes",$pedidosPendientes) ;
        $this->view->setVar("pedidosTotales",$pedidosTotales) ;
        $this->view->setVar("estadosMesa",$estadosMesa) ;

        $this->view->pick("controllers/waiter/_index");
    }

     /**
    * details
    *
    *
    * @author Hernán Feliú
    *
    * Renderiza Detalles Mesa via mifaces
    *
    */

    public function tableDetailsAction(){

        if($this->request->isAjax()){

            $this->mifaces->newFaces();

            if (isset($_POST['table_id'])){
           
                $view = "controllers/waiter/tables/details";

                
                $param['mesa_id'] = $this->request->getPost("table_id", "int");

                $tabObj = new MeseroBSN();
                $tablesDetails = $tabObj->getDataCuentasByMesa($param);

                $dataView['detalles'] =  $tablesDetails;
                $dataView['numeroMesa'] = reset($tablesDetails)['cuenta']->Mesas->numero;

                $dataView['cuenta_id']  = $this->request->getPost("cuenta_id", "int");
                $dataView['table_id']    = $this->request->getPost("table_id", "int");
                $dataView['table_numero']    = $this->request->getPost("table_numero", "int");



            
                $toRend = $this->view->getPartial($view, $dataView);

                $this->mifaces->addToRend('waiter_tables_details_render',$toRend);

            }else{

                $this->mifaces->addToMsg('danger','Error Inesperado. Refresque la página.');

            }

                

    	        //$toRend = $this->view->getPartial($view, $dataView);


            
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}	


    /**
    * BillDetails
    *
    *
    * @author osanmartin
    *
    * Renderiza modal detalles cuenta via mifaces
    *
    */    
    public function billDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            if(isset($post['cuenta'])){

                $view = "controllers/waiter/tables/orders";
                
                $cuenta_id = $post['cuenta'];
                $param['cuenta_id'] = $cuenta_id;
                $param['estado_id'] = 1; 


                $pedidosCuenta  = $this->pedidoBsn->getAllOrders($param);
                $cuenta         = $this->cajaBsn->getCuentaById($param);

                $dataView['pedidosCuenta']  =  $pedidosCuenta;
                $dataView['cuenta']         =  $cuenta;
                //print_r($cuenta);exit();
                
                $toRend = $this->view->getPartial($view, $dataView);

                $this->mifaces->addToRend('table_modal_orders_render',$toRend);

            }else{

                $this->mifaces->addToMsg('danger','Error Inesperado. Refresque la página.');
            }
           
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }


    }


    /**
    * validateOrders
    *
    *
    * @author osanmartin / Hernán Feliú
    *
    * cambia estado a una serie de pedidos 
    *
    */

    public function validateOrdersAction(){   

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            $resultValidacion = false;
            $resultCancelacion = false;

            if(isset($post['table_id'])) {

                if(isset($post['pedidosValidados'])){

                    $pedidosValidados = $post['pedidosValidados'];
                    $resultValidacion = $this->pedidoBsn->validateOrders($pedidosValidados);

                    if(!$resultValidacion){

                        $this->mifaces->addToMsg('warning','Los pedidos no han sido validados correctamente!');

                    }

                }

                if(isset($post['pedidosNoValidados'])){

                     $pedidosNoValidados = $post['pedidosNoValidados'];
                     $resultCancelacion = $this->pedidoBsn->cancelOrders($pedidosNoValidados);
                     
                     if(!$resultCancelacion){

                        $this->mifaces->addToMsg('warning','Los pedidos no han sido cancelados correctamente!');

                    }

                }

                if($resultValidacion || $resultCancelacion){

                     $this->mifaces->addToDataView('resultValidation', 1);

                }else{
                    $this->mifaces->addToDataView('resultValidation', 0);
                }

                $this->mifaces->addToMsg('success','Los pedidos han sido procesados correctamente!');
                
                $param['mesa_id'] = $post['table_id'];

                $tabObj = new MeseroBSN();
                $tablesDetails = $tabObj->getDataCuentasByMesa($param);
               
                $dataView['detalles'] =  $tablesDetails;
                $dataView['numeroMesa'] = array_values($tablesDetails)[0]['cuenta']->Mesas->numero;


                $view = "controllers/waiter/tables/details";
             
                $toRend = $this->view->getPartial($view, $dataView);
                $this->mifaces->addToRend('waiter_tables_details_render',$toRend);

            }

            else {
                $this->mifaces->addToMsg('error','Error interno!');
            }
            
            $this->mifaces->run();
        } else{

            $this->view->disable();

        }
    }

    /**
     * createUser
     *
     * levanta el modal para crear un usuario
     *
     * @author Sebastián Silva
     */
    public function createUserAction(){

        if($this->request->isAjax()) {

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            $view = "controllers/waiter/modal_create_user";

            $dataView['mesa_id']    =  $post['mesa'];

            $toRend = $this->view->getPartial($view, $dataView);

            $this->mifaces->addToRend('table_modal_orders_render',$toRend);
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }
    }

    /**
     * storeClient
     * 
     * persiste el cliente desde la vista mesero
     *
     * @author Sebastián Silva
     */
    public function storeClientAction() {

        if($this->request->isAjax()) {

            $cuenta_id  = $this->request->getPost("cuenta_id", "int");
            $table_id   = $this->request->getPost("table_id", "int");
            $nombre     = $this->request->getPost("nombre-cliente", "string");

            if( empty($table_id)    OR 
                empty($nombre)) {

                $this->mifaces->addToMsg('danger','Faltan datos para crear cliente, vuelta a intentarlo.');  
                $this->mifaces->run();
                return false;
            }

            if($cuenta_id == 0 OR empty($cuenta_id)){
                $cuenta_id = null;
            }

            


            // creo el usuario y le asigno la cuenta
            $mesero = new MeseroBSN();

            $param = array(
                'nombre'    => $nombre,
                'cuenta_id' => $cuenta_id,
                'table_id'  => $table_id
            );
            

            if( $mesero->setNewClient( $param ) ) {


                
                $this->mifaces->newFaces();

                $view = "controllers/waiter/tables/details";

                
                $param['mesa_id'] = $table_id;



                $tabObj = new MeseroBSN();
                $tablesDetails = $tabObj->getDataCuentasByMesa($param);
                
                $dataView['detalles']   =  $tablesDetails;

                $dataView['cuenta_id']  = $this->request->getPost("cuenta_id", "int");
                $dataView['table_id']   = $this->request->getPost("table_id", "int");

                $dataView['numeroMesa'] = array_values($tablesDetails)[0]['cuenta']->Mesas->numero;


                $toRend = $this->view->getPartial($view, $dataView);

                $this->mifaces->addToRend('waiter_tables_details_render',$toRend);
                $this->mifaces->run();

                
            } else{
                $this->mifaces->newFaces();
                $this->mifaces->addToMsg('danger','No se ha podido crear el cliente, vuelta a intentarlo.');
                $this->mifaces->run();
            }

            
            

        } else{
            $this->mifaces->newFaces();
            $this->view->disable();
            $this->mifaces->run();
        }

    }

    /**
     * createOrder
     * 
     * setea las variables y redirige al menú
     *
     * @author Sebastián Silva
     */
    public function createOrderAction($cuenta_id){

        #js custom
        $this->assets->addJs('js/pages/menu.js');

        // Al cambiar este parámetro, se debe cambiar también la vista.
        $paramCategoria = ["categoria_id" => $this->ID_CATEGORY_BEBIDAS];

        
        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

        $this->view->setVar("productos",        $productos );
        $this->view->setVar("subcategorias",    $subcategorias );
        $this->view->setVar("cuenta_id",        $cuenta_id );


        $param = array(
            'cuenta_id' => $cuenta_id
        );

        $meserobsn = new MeseroBSN();

        $table  = $meserobsn->getTableByCuenta($param);
        $client = $meserobsn->getClientByCuenta($param);


        $this->view->setVar("table",    $table );
        $this->view->setVar("client",   $client );

        # seteamos las variables de sesion
        # el id de la cuenta y el id de la mesa    
        $this->session->set('auth-identity', array(
            'id'        =>  $this->session->get("auth-identity")['id'],
            'rol'       =>  $this->session->get("auth-identity")['rol'],
            'cuenta'    =>  $cuenta_id,
            'nombre'    =>  $this->session->get("auth-identity")['nombre'],
            'mesa'      =>  $table->id
        ));
        
        #vista
        $this->view->pick("controllers/menu/_index_waiter");
    }

    /*
    * BillDetails
    *
    *
    * @author osanmartin
    *
    * Renderiza modal detalles cuenta via mifaces
    *
    */    
    public function getPendingOrdersAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $this->mifaces->newFaces();

            if(isset($post['cuenta'])){

                $view = "controllers/waiter/tables/pending_orders";

                $param = [
                    "nombre" => $this->constant->ESTADO_PEDIDO_PENDIENTE
                ];

                $pedidobsnObj = new PedidoBSN();
                $status = $pedidobsnObj->getStatus($param);

                $cuenta_id = $post['cuenta'];
                $param['cuenta_id'] = $cuenta_id;
                $param['estado_id'] = $status->id; 

                $pedidosCuenta  = $this->pedidoBsn->getAllOrders($param);
                $cuenta         = $this->cajaBsn->getCuentaById($param);

                $dataView['pedidosCuenta']  =  $pedidosCuenta;
                $dataView['cuenta']         =  $cuenta;

                $toRend = $this->view->getPartial($view, $dataView);

                $this->mifaces->addToRend('table_modal_pending_orders_render',$toRend);

            }else{

                $this->mifaces->addToMsg('danger','Error Inesperado. Refresque la página.');
            }
           
            $this->mifaces->run();

        } else{

            $this->view->disable();

        }

    }

}

