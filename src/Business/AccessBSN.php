<?php
	/**
     * Modelo de negocio Control de acceso
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * para el control de acceso al sistema, creación de usuarios temporales
     * y manejo de sesiones
     *
     * @package      MiBar
     * @subpackage   Business
     * @category     Access Business
     * @author       Zenta Group
     */
	namespace App\Business;

    use App\Models\Clientes;
    use App\Models\Cuentas;

	use Phalcon\Mvc\User\Plugin;

	/**
     * Modelo de negocio Control de acceso
     *
     * Acá se encuentra todo el modelo de negocios relacionado
     * para el control de acceso al sistema, creación de usuarios temporales
     * y manejo de sesiones
     *
     * @author zenta group
     */
	class AccessBSN extends Plugin
	{
        /**
         *
         * @var string
         */ 
        public $error;

        /**
         *
         * @var integer Constante para estado "en atencion"
         */        
        private $ROL_CLIENTE = 6;
        
        /**
         * 
         * @var integer Estado de la cuenta
         */
        private $SIN_PAGAR = 1;


        /**
         * Creación usuario temporal
         *
         * crearemos un usuario temporal en la base de datos
         * iniciaremos las variables de sesión
         *
         * @author  Sebastián Silva C
         *
         * @param   string $username nombre de usuario
         * @return  boolean
         */
        public function createTmpUser($username) {

            $this->db->begin();

            $cliente = new Clientes();

            $cliente->nombre            = $username;
            $cliente->tipo_cliente_id   = 2;


            if($cliente->save() == false) {

                foreach ($cliente->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                $this->db->rollback();
                return false;
            }

            # Creamos una cuenta para el cliente
            $cuenta = $this->initCuenta($cliente);

            if(!$cuenta) {

                $this->error[] = $this->errors->WS_CONNECTION_FAIL;
                $this->db->rollback();
                return false;
            }

            # Creamos las variables de sesion
            $sesion = $this->initSession($cliente, $cuenta);

            if(!$sesion) {

                $this->error[] = $this->errors->WS_CONNECTION_FAIL;
                $this->db->rollback();
                return false;
            }

            $this->db->commit();

            return $cliente;
        }

        /**
         * Init cuenta
         *
         * se crea una cuenta asignada al usuario temporal
         *
         * @author Sebastián Silva
         */
        private function initCuenta(\App\Models\Clientes $cliente) {

            $cuenta = new Cuentas();

            $cuenta->cliente_id = $cliente->id;
            $cuenta->estado = $this->SIN_PAGAR;


            if( $cuenta->save() == false ) {

                foreach ($cuenta->getMessages() as $message) {
                    $this->error[] = $message->getMessage();
                }

                return false;
            }

            return $cuenta;
        }

        /**
         * Init Session
         *
         * se crean las variables de sesión
         *
         * @author Sebastián Silva
         */
        private function initSession(\App\Models\Clientes $cliente, \App\Models\Cuentas $cuenta) {

            $this->session->set('auth-identity', array(

                'id'        => $cliente->id,
                'rol'       => $this->ROL_CLIENTE,
                'cuenta'    => $cuenta->id,
                'nombre'    => ucwords( strtolower( $cliente->nombre." ".$cliente->apellido ) ),
                'mesa'      => 1 // NUMERO PRUEBA

            ));

            return true;
        }

        /**
         * Eliminar Session
         *
         * se eliminan las variables de session
         *
         * @author Sebastián Silva
         */
        public function deleteSession() {

            if(is_array( $this->session->get("auth-identity") )) {

                /*
                $cliente_id =$this->session->get("auth-identity")['id'];
                
                if( !empty($cliente_id) ) {

                    $cliente = Clientes::findFirstById($cliente_id);

                    if($cliente){

                    }
                }
                */

                $this->auth->remove();
                $this->session->destroy();

                return true;
            }
        }
    }