<?php

namespace App\Controllers;

class WaiterController extends ControllerBase
{
	
    public function indexAction()
    {
    	#js custom
        $this->assets->addJs('js/pages/waiter.js');
        
        #vista
        $this->view->pick("controllers/waiter/_index");
    }

    public function tableDetailsAction(){

        if($this->request->isAjax()){

            $post = $this->request->getPost();
            $view = "controllers/waiter/tables/modal";
            $this->mifaces->newFaces();


	        $dataView = "Holiwi";
	       
	        $toRend = $this->view->getPartial($view, $dataView);

	        $this->mifaces->addToRend('table-modal',$toRend);
        	$this->mifaces->run();

        } else{

        	$this->view->disable();

        }

	}	


}

