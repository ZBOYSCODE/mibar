<?php

namespace App\Controllers;

use App\Business\ProductoBSN;
use App\Business\PromocionBSN;



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

        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

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


        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}	



}