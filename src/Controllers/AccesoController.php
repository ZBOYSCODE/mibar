<?php
	/**
     * Controlador de acceso
     *
     * Este controlador tiene como fin controlar el acceso al sistema
     *
     * @package      MiBar
     * @subpackage   Controller
     * @category     Auth
     * @author       Zenta Group
     */
	namespace App\Controllers;


	use App\Business\AccessBSN;

	/**
     * Controlador de acceso
     *
     * Este controlador tiene como fin controlar el acceso al sistema
     *
     * @author zenta group
     */
	class AccesoController extends ControllerBase
	{

		public function initialize()
		{
	    	$this->_themeArray = array('topMenu'=>true, 'menuSel'=>'','pcView'=>'', 'pcData'=>'', 'jsScript'=>'');
	    }
	
		public function denegadoAction()
		{

    		$content    = 'acceso/denegado';


            $pcData = '';


            echo $this->view->render('theme',array('pcView'=>$content,'pcData'=>$pcData, )); 
		}

		/**
         * Login
         *
         * login dara las instrucciones para la creación de un usuario temporal
         * y el manejo de su sesión
         *
         * @author Sebastián Silva
         */
        public function loginAction(){

        	/*if(!isset($_POST['wel-username'])){
        		return $this->response->redirect();
        	}*/
            
            $this->valida->validate($_POST, array(
                'wel-username'     => "required|string|min:4	|max:200"
            ));

            if ( $this->valida->failed() ) {
                # seteamos el error
                $this->flashSession->error( $this->valida->getErrors()['wel-username'] );

        		// Make a full HTTP redirection
        		return $this->response->redirect();
            }
            

            $access = new AccessBSN();

            if( $access->createTmpUser( $_POST['wel-username'] ) ) {

            	return $this->response->redirect("menu");

            } else {

            	foreach ($access->error as $key => $err) {

            		$this->flashSession->error($err);
            	}

        		return $this->response->redirect();
            }
        }

        /**
         * LogOut
         *
         * logout, se elimna las variables de session y el usuario temporal
         *
         * @author Sebastián Silva
         */
        public function logoutAction() {

            $access = new AccessBSN();

            $access->deleteSession();

            

            return $this->response->redirect('login');
        }

	}