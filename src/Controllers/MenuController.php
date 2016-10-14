<?php

namespace App\Controllers;



class MenuController extends ControllerBase
{

    public function indexAction()
    {
    	#js custom
        $this->assets->addJs('js/pages/menu.js');
        
        #vista
        $this->view->pick("controllers/menu/_index");
    }

}