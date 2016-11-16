<?php

	namespace App\Controllers;

	use App\library\Constants\Constant;



	class ChatController extends ControllerBase
	{

		/**
	     * initialize
	     *
	     * @author Sebastián Silva
	     */

	    public function initialize()
	    {
	        parent::initialize();
	    }


	    /**
	     * indexAction
	     *
	     * @author Sebastián Silva
	     */
	    public function indexAction() {

	        #js custom
	        $this->assets->addJs('js/pages/chat.js');


	        $this->view->setVar('username', $this->session->get('auth-identity')['nombre']);
	        $this->view->setVar('table', $this->session->get('auth-identity')['mesa']);


	        $this->view->pick('controllers/chat/_index');
	    }
	}
