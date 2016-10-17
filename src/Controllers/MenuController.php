<?php

namespace App\Controllers;

use App\Business\ProductoBSN;



class MenuController extends ControllerBase
{
	// Constantes

	private $ID_CATEGORY_BEBIDAS = 1;

	// Business

	private $productoBsn;



	public function initialize(){
		$this->productoBsn = new ProductoBSN();
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


        $paramCategoria = ["categoria_id" => $this->ID_CATEGORY_BEBIDAS];

        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

        $this->view->setVar("productos", $productos);
        $this->view->setVar("subcategorias", $subcategorias);

        #vista
        $this->view->pick("controllers/menu/_index");
    }


	/**
	* changeMenu
	*
	* @author osanmartin
	*
	* Renderiza la vista de productos según el parámetro seleccionado
	*
	*
	*/    

	public function changeMenuAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/menu/promos/_index";
            $this->mifaces->newFaces();


            if(isset($post["categoria"])){

            	$categoria_id = $post["categoria"];

		        $paramCategoria = ["categoria_id" => $categoria_id];


		        $productos = $this->productoBsn->getProductsbyCategory($paramCategoria);
		        $subcategorias = $this->productoBsn->getListSubCategoriesByCategory($paramCategoria);

		        $dataView["productos"] = $productos;
		        $dataView["subcategorias"] = $subcategorias;



		        $toRend = $this->view->getPartial($view, $dataView);

		        $this->mifaces->addToRend('menu-products',$toRend);

        	} else{

				$this->mifaces->addToMsg("danger", "Error Inesperado.");

        	}

        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}



}