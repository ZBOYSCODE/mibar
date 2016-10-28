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

            $dataView['total_pedido'] 	= $this->getTotalPedido();

            $dataView["cuenta_id"] 		= $this->session->get("auth-identity")['cuenta'];
            $dataView["mesa"] 			= $this->session->get("auth-identity")['mesa'];

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
	* miCuenta
	*
	* Renderiza modal "Mi cuenta" 
	*
	* @author Sebastoán Silva
	*/
	public function miCuentaAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/cuenta/modal";

            $this->mifaces->newFaces();

            $pedidos = new PedidoBSN();

            //$dataView["pedidos"] 		= $pedidos->getPedidos();

            $dataView['total_pedido'] 	= number_format($this->getTotalCuenta(), 0, ',', '.')  ;

	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('orders-modal',$toRend);
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }
	}	

	/**
	* miCuenta
	*
	* Renderiza modal "Mi cuenta" 
	*
	* @author Sebastoán Silva
	*/
	public function misPedidosAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/pedidos/modal";

            $this->mifaces->newFaces();


            $dataView['pedidos'] 	= $this->getListPedidos();


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
	public function getResumenDatosAction() { //getNumPedidos

		$data = array();


		$data['total_pedidos'] 	= $this->getNumPedidos();
		$data['precio_total']	= $this->getTotalPedido();


        echo json_encode($data);
	}

	public function getTotalCuenta() {

		$precio_total = 0;

		$pedidos = new PedidoBSN();

		$param = array(
			'cuenta_id' => $this->session->get("auth-identity")['cuenta']
		);

		$list = $pedidos->getOrdersWithoutPayment($param);

		if ( !$list ){
			return 0;
		}

		foreach ($list as $pedido) {

			$precio_total += $pedido->precio;
		}

        return $precio_total;
	}

	private function getListPedidos() {


		$precio_total = 0;

		$pedidos = new PedidoBSN();

		$param = array(
			'cuenta_id' => $this->session->get("auth-identity")['cuenta']
		);


		$list = $pedidos->getAllOrders($param);

		if ( !$list ){
			return array();
		}

		$lista_pedidos = array();

		foreach ($list as $pedido) {


			if( !empty( $pedido->producto_id ) &&  empty( $pedido->promocion_id ) ) {
				// Producto

				$lista_pedidos[$pedido->created_at][$pedido->producto_id]['producto'] = $pedido->toArray();
				$lista_pedidos[$pedido->created_at][$pedido->producto_id]['es_promocion'] = 0;

				if ( !isset($lista_pedidos[$pedido->created_at][$pedido->producto_id]['cantidad']) ) {

					$lista_pedidos[$pedido->created_at][$pedido->producto_id]['cantidad'] = 1;
				} else {
					$lista_pedidos[$pedido->created_at][$pedido->producto_id]['cantidad']++;
				}

			} else {
				// Promoción

				$lista_pedidos[$pedido->created_at][$pedido->promocion_id]['producto'] = $pedido->toArray();
				$lista_pedidos[$pedido->created_at][$pedido->promocion_id]['es_promocion'] = 1;

				if ( !isset($lista_pedidos[$pedido->created_at][$pedido->producto_id]['cantidad']) ) {

					$lista_pedidos[$pedido->created_at][$pedido->promocion_id]['cantidad'] = 1;
				} else {
					$lista_pedidos[$pedido->created_at][$pedido->promocion_id]['cantidad'] ++;
				}
			}
		}

        return $lista_pedidos;
	}

	private function getTotalPedido() {

		$precio_total = 0;

		if ( $this->session->has("pedidos") ) {

			$pedidos = $this->session->get("pedidos");

			$prod = new ProductoBSN();
			$prom = new PromocionBSN();

		
			foreach ($pedidos as $pedido) {

				if($pedido['es_promocion']) {

					$precio = $prom->getPrecioById($pedido['producto_id']);
					$precio_total += $precio * $pedido['cantidad'];
				} else {


					$precio = $prod->getPrecioById($pedido['producto_id']);
					$precio_total += $precio * $pedido['cantidad'];
				}
			}
        }

        return $precio_total;

	}

	private function getNumPedidos() {

		if ($this->session->has("pedidos")) {	

            $pedidos = $this->session->get("pedidos");
            return count($pedidos);
        } else {

            return 0;
        }
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










