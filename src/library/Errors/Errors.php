<?php
    namespace App\library\Errors;

    use Phalcon\Mvc\User\Component;
    use Phalcon\Mvc\Dispatcher;


    class Errors extends Component {

        public $DB_CONNECTION_FAIL = 'Se cayó la conexión con la base de datos, reintente más tarde';

        public $NO_RECORDS_FOUND = 'No se encontraron registros';

        public $NO_RECORDS_FOUND_ID = 'No se encontraron registros con el ID ingresado';

        public $WS_CONNECTION_FAIL = 'Falló la conexión con el servicio web, reintente más tarde';

        public $FILE_ACCESS_FAIL = 'No es posible acceder al archivo, reintente mas tarde';

        public $FILE_WRITE_FAIL = 'No es posible guardar el archivo';

        public $MISSING_PARAMETERS = 'Faltan parametros para realizar la consulta';

        public $WRONG_PARAMETERS = "El dato ingresado no corresponde al solicitado";

        public $DUPLICATE_ELEMENT = "El elemento ya se encuentra en la Base de datos";

        public $EMAIL_EXISTS = "El email ya existe";

        public $UNKNOW = "Error interno del servidor";

    }