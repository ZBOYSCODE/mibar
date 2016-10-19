<?php

namespace App\Controllers;


use App\Business\ProductoBSN;
use App\Business\PromocionBSN;
use App\Business\PedidoBSN;



class MenuController extends ControllerBase
{
	// Constantes

	private $ID_CATEGORY_BEBIDAS = 1;
	private $ID_CATEGORY_COMIDAS = 2;

	// Business

	private $productoBsn;
	private $promocionBsn;



	public function initialize(){
		$this->productoBsn = new ProductoBSN();
		$this->promocionBsn = new PromocionBSN();
	}

	/**
	*  Menú
	*
	* @author osanmartin
	* Carga por defecto una categoría específica y te lleva al menú de la app.
	*
	*
	*/
    public function indexAction()
    {
    	#js custom
        $this->assets->addJs('js/pages/menu.js');

        // Al cambiar este parámetro, se debe cambiar también la vista.
        $paramCategoria = ["categoria_id" => $this->ID_CATEGORY_BEBIDAS];

        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

        $this->view->setVar("productos", $productos);
        $this->view->setVar("subcategorias", $subcategorias);


        #vista
        $this->view->pick("controllers/menu/_index");
    }


	/**
	* changeMenuDrinks
	*
	* @author osanmartin
	*
	* Renderiza la vista de bebidas según el parámetro seleccionado
	*
	*
	*/    

	public function changeMenuDrinksAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/drinks/_index";
            $this->mifaces->newFaces();


	        $paramCategoria = ["categoria_id" => $this->ID_CATEGORY_BEBIDAS];

	        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
	        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

	        $dataView["productos"] = $productos;
	        $dataView["subcategorias"] = $subcategorias;



	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('menu-products',$toRend);
	        $this->mifaces->addToDataView("menuNav", "opcion1");

        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}


	/**
	* changeMenuFoods
	*
	* @author osanmartin
	*
	* Renderiza la vista de comidas según el parámetro seleccionado
	*
	*
	*/    

	public function changeMenuFoodsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/foods/_index";
            $this->mifaces->newFaces();


	        $paramCategoria = ["categoria_id" => $this->ID_CATEGORY_COMIDAS];

	        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
	        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

	        $dataView["productos"] = $productos;
	        $dataView["subcategorias"] = $subcategorias;



	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('menu-products',$toRend);
	        $this->mifaces->addToDataView("menuNav", "opcion2");

        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }
	}




	/**
	 * addPedido
	 *
	 * ingresa una nueva lista de pedidos
	 *
	 * @author Sebastián Silva
	 */
	public function  addPedidoAction() {

		$listado =  json_decode($_POST['pedidos']);

		$pedido = new PedidoBSN();

		$data = array();

		$param = array(
			'pedidos' => $listado
		);

		if( $pedido->savePedidoSesion($param) ) {

			$data['success'] = true;

		} else {

			$data['success'] = false;
			$data['msg'] = $pedido->error;
		}

		echo json_encode($data);
	}

	/**
	* changeMenuPromocion
	*
	* @author osanmartin
	*
	* Renderiza la vista de promociones 
	*
	*
	*/    
	public function changeMenuPromocionAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/promos/_index";
            $this->mifaces->newFaces();

	        $promociones = $this->promocionBsn->getPromociones();

	        $subcategorias = $this->promocionBsn->getListTipoPromo();

	        $dataView["promociones"] = $promociones;
	        $dataView["subcategorias"] = $subcategorias;



	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('menu-products',$toRend);
		    $this->mifaces->addToDataView("menuNav", "opcion0");



        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }
	}


	/**
     * concreta el pedido
     *
     * se crea una orden con la lista de pedidos
     * 
     * @author Sebastián Silva
     *
     * @return json
     */
    public function concretarPedidoAction() {

        $data = array();


        if ($this->session->has("pedidos")) {

        	$pedidos = new PedidoBSN();

	        $lista_pedidos = $this->session->get("pedidos");

	        $param = array(
	        	'cuenta_id' => $this->session->get("auth-identity")['cuenta'],
	        	'pedidos'	=> $lista_pedidos
	        );


	        if( $pedidos->createOrder($param) ) {

	        	$data['success'] = true;

	        	$this->deleteAllPedidos();
	        } else {

	        	print_r($pedidos->error);

	        	$data['success'] = false;
	        	$data['msg'] = $pedidos->error;
	        }

        } else {

        	$data['success'] = false;
        	$data['msg'] = "No existen pedidos en el carro.";
        }


	        

        echo json_encode($data);
    }

	/**
	* MyOrders
	*
	* @author Hernán Feliú
	*
	* Renderiza modal "Mis Pedidos" 
	*
	*/
	public function myOrdersAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/orders/modal";
            $this->mifaces->newFaces();


            $dataView["cuenta_id"] 	= $this->session->get("auth-identity")['cuenta'];
            $dataView["mesa"] 		= $this->session->get("auth-identity")['mesa'];

            $pedidos = new PedidoBSN();

            $dataView["pedidos"] 	= $pedidos->getPedidos();

	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('orders-modal',$toRend);
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }
	}	

	/**
	 * removePedido
	 *
	 * remueve un pedido del carro
	 *
	 * @author Sebastián Silva
	 * @return json
	 */
	public function removePedidoAction() {

		$data= array();

		if(!isset($_POST['pedido'])){

			$data['success'] = false;
			echo json_encode($data);
			return false;
		}

		$lista_pedidos = array();

		if ($this->session->has("pedidos")) {

            $pedidos = $this->session->get("pedidos");
            unset( $pedidos[$_POST['pedido']] );

            $this->session->set('pedidos', $pedidos);
			
			$data['success'] = true;
			$data['pedido'] = $_POST['pedido'];
        } else {

        	$data['success'] = false;
        }

		echo json_encode($data);
	}

	/**
	 * getNumPedidos
	 *
	 * obtiene el número de pedidos en el carro
	 *
	 * @author Sebastián Silva
	 * @return json
	 */
	public function getNumPedidosAction() {

		if ($this->session->has("pedidos")) {

            $pedidos = $this->session->get("pedidos");
            
            $data['success'] 	= true;
            $data['num'] 		= count($pedidos);
        } else {

        	$data['success'] 	= true;
            $data['num'] 		= 0;
        }

        echo json_encode($data);
	}

	/**
	 * deleteAllPedidos
	 *
	 * elimina todos los pedidos del carro de compra
	 *
	 * @author Sebastián Silva
	 * @return boolean
	 */
	private function deleteAllPedidos() {

		if ($this->session->has("pedidos")) {

            $this->session->remove("pedidos");
        }

        return true;
	}

}










