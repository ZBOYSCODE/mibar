<?php

	namespace App\Controllers;

	use App\Business\FavoriteBSN;
	use App\library\Valida\Valida;

	class FavoriteController extends ControllerBase
	{
		private $fav;

		public function initialize()
		{
	    	$this->fav = new FavoriteBSN();
	    }

	    /**
	     * Index
	     *
	     * carga todos los datos necesarios, para luego llamar a la vista 
	     *
	     * @author Sebastián Silva Carrasco
	     */
	    public function indexAction()
	    {
	    	$this->fav->user_id = $this->auth->getIdentity()['id'];

	    	$drugs 			= $this->fav->getListDrugs();
	    	$exams 			= $this->fav->getListExams();
	    	$procedures 	= $this->fav->getListProcedures();
	    	$diagnostics 	= $this->fav->getListDiagnostics();

	    	$fav_drugs 			= $this->fav->getListFavorites('Drugs');
	    	$fav_exams 			= $this->fav->getListFavorites('Exams');
	    	$fav_procedures 	= $this->fav->getListFavorites('Process');
	    	$fav_diagnostics 	= $this->fav->getListFavorites('Diagnostics');

            $this->view->setVar("drugs", 		$drugs);
            $this->view->setVar("exams", 		$exams);
            $this->view->setVar("procedures", 	$procedures);
            $this->view->setVar("diagnostics", 	$diagnostics);

            $this->view->setVar("fav_drugs", 		$fav_drugs);
            $this->view->setVar("fav_exams", 		$fav_exams);
            $this->view->setVar("fav_procedures", 	$fav_procedures);
            $this->view->setVar("fav_diagnostics", 	$fav_diagnostics);

            $this->assets->addJs('js/pages/favorites.js');
			$this->view->pick("controllers/favorites/_index");
	    }

	    /**
	     * añadir favoritos
	     *
	     * obtiene la lista de favoritos y los guardamos en la base de datos
	     * los datos obtenidos llegan mediante el metodo POST
	     *
	     * @author Sebastián Silva Carrasco
	     * @return string json
	     */
	    public function addFavAction(){

	    	$table = $_POST['table'];
	    	$list = $_POST['list'];

	    	$valida = new Valida($_POST, [
	            'table'    => "required|string"
	        ]);

	        if($valida->failed()){
	            $data['success'] = false;
	            $data['msg'] = $valida->errors;
	            echo json_encode($data);
	            exit;
	        }

	    	$this->fav->user_id = $this->auth->getIdentity()['id'];

	    	if( $this->fav->addFav($list, $table) ) {

	    		$data['success'] = true;
	    	
	    	} else {

	    		$data['success'] = false;
	    		$data['msg'] = $this->fav->error;
	    	}

	    	echo json_encode($data);
	    }

	    /**
	     * obtener favoritos
	     *
	     * obtiene la lista de favoritos pertenecientes a un especialista
	     * devuelve solo los favoritos de la tabla indicada
	     *
	     * @author Sebastián Silva Carrasco
	     * @return string json
	     */
	    public function getFavByTableAction() {

	    	$data = array();


	    	$valida = new Valida($_POST, [
	            'table'    => "required|string"
	        ]);

	        if($valida->failed()){
	            $data['success'] = false;
	            $data['msg'] = $valida->errors;
	            echo json_encode($data);
	            exit;
	        }


	    	$table = $_POST['table'];

	    	$this->fav->user_id = $this->auth->getIdentity()['id'];

	    	$result = $this->fav->getFavByTable($table);

	    	if(!$result) {

	    		$data['success'] 	= false;
	    		$data['msg'] 		= $this->fav->error;

	    	} else {
	    		$data['success'] 	= true;

	    		$arr = array();
	    		foreach ($result as $favorito) {
	    			
	    			$fav = new \StdClass();
	    			$fav->id 	= $favorito->id;

	    			if($table == 'Diagnostics'){

	    				$fav->name 	= $favorito->$table->descriptor;

	    			} else {
	    				$fav->name 	= $favorito->$table->name;
	    			}
	    			

	    			array_push($arr, $fav);
	    		}

	    		$data['result'] = $arr;
	    		$data['table'] = strtolower($table);
	    	}

	    	echo json_encode($data);
	    }

	    /**
	     * eliminar favoritos
	     *
	     * elimina un favorito
	     *
	     * @author Sebastián Silva Carrasco
	     * @return string json
	     */
	    public function deleteFavAction() {

	    	$data = array();

	    	$valida = new Valida($_POST, [
	            'idfav'    => "required|int|min:0"
	        ]);

	        if($valida->failed()){
	            $data['success'] = false;
	            $data['msg'] = $valida->errors;
	            echo json_encode($data);
	            exit;
	        }


	    	$idfav = $_POST['idfav'];


	    	if($this->fav->deleteFavorite($idfav)){

	    		$data['success']	= true;
	    		$data['idfav'] 		= $idfav;
	    	
	    	} else {

	    		$data['success']	= false;
	    		$data['msg']		= $this->fav->error;
	    	}

	    	echo json_encode($data);
	    }
	}
















