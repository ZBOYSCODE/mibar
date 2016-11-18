<?php

namespace App\Controllers;


use App\Business\PedidoBSN;
use App\Business\ProductoBSN;

use App\library\Constants\Constant;


ini_set('memory_limit', '-1');


class ScannerController extends ControllerBase
{

    private $constant;

    /**
     * initialize
     *
     * @author Jorge Silva
     *
     * inicializa la clase
     */
    public function initialize()
    {
        parent::initialize();

        $this->constant = new Constant();
    }


    /**
     * indexAction
     *
     * @author Jorge Silva
     *
     * Index de la pagina del scanner de imagen, redirige a show.
     *
     */
    public function indexAction()
    {   

        $this->contextRedirect("scanner/show");

    }

    /**
     * showAction
     *
     * index del controlador, muestra un formulario para subir el QR
     * y setear la mesa
     *
     * @author Sebastián Silva
     */
    public function showAction(){
        if($this->request->isGet()){

            #js custom
            $this->assets->addCss("css/plugins/file-input.css");
            $this->assets->addJs('js/pages/scanner.js');

            $this->view->pick("controllers/scanner/_index");
        }
    }

    /**
     * tableAction
     *
     * obtiene la imagen enviada por el formulario
     * la redimenciona y la lee, obtenemos el id de la mesa
     * y redirigimos al login, donde pedirá solo el nombre
     *
     * @author Sebastián Silva
     */
    public function tableAction () {

        $data = array();

        $nombre = $this->generaNameRandom();


        if ($this->request->hasFiles() == true) {     

        
            foreach ($this->request->getUploadedFiles() as $file) {
               
                $ruta = "files/qr/".$nombre.".".$file->getExtension();

                $mime = $file->getType();

                // Move the file into the application
                if (  $result = $file->moveTo($ruta) ){

                    $data['ruta'] = $ruta;
                    $data['mime'] = $mime;


                    $this->resize($ruta, $mime);


                    $textqr = $this->readQr($ruta);

                    if ( $textqr == false ){

                        $data['success'] = false;

                        $this->flash->message("error", "Error al leer el código QR, favor intentar nuevamente.");
                        $this->contextRedirect("scanner/show");
                    }


                    $data['textqr'] = $textqr;

                    $mesa = (int)$this->getTableByQr($textqr);

                    $data['mesa'] = $mesa;

                    if( $this->session->has('table_id_tmp') ) {
                        
                        $this->session->remove('table_id_tmp');
                    }

                    $this->session->set('table_id_tmp', $mesa);

                    $data['success'] = true;

                    $data['redirect'] = $this->config->get('application')['publicUrl'].'login';

                    
                    unlink(BASE_DIR."/public/{$ruta}");
                    $this->contextRedirect('login');
                
                } else {
                    $data['success'] = false;
                }
            }


            $this->flash->message("error", "Es necesario que subas una código QR.");
            $this->contextRedirect("scanner/show");

            echo "<pre>";
            echo json_encode($data);
        }
    }

    /**
     * readQr
     * 
     * instanciamos la clase que lee el codigo qr
     * devolvemos el string
     *
     * @author Sebastián Silva
     *
     * @param string $ruta  ruta de la imagen
     * @return string $qrcode_text texto del qr
     */
    private function readQr($ruta) {

        $QRCodeReader = new \Libern\QRCodeReader\QRCodeReader();
        $qrcode_text = $QRCodeReader->decode( $ruta );

        return $qrcode_text;
    }

    /**
     * generaNameRandom
     * 
     * genera un nombre random para las imagenes subidas
     *
     * @author Sebastián Silva
     *
     * @return string nombre de la imagen
     */
    private function generaNameRandom() {

        $fecha  = date('YmdHis');
        $rand   = rand(5, 10000);

        return  $rand."_".$fecha ;
    }

    /**
     * getTableByQr
     * 
     * analizamos el string devuelvo por el Qr
     * y obtenemos el id de la mesa
     *
     * @author Sebastián Silva
     *
     * @param string $textqr texto del qr
     * @return integer table_id
     */
    private function getTableByQr($textqr) {

        $arr = explode('/', $textqr);

        $num = count($arr);

        return $arr[$num-1];

    }

    /**
     * resize
     * 
     * redimencionamos la imagen para poder enviarsela a la clase QRCodeReader
     *
     * @author Sebastián Silva
     *
     * @param string $ruta ruta de la imagen
     * @param string $mime tipo mime de la imagen subida
     * @return boolean
     */
    private  function resize($ruta, $mime)
    {
        # Obtenemos el ancho y alto de la imagen
        $imagen = getimagesize($ruta);
        $width  = $imagen[0];
        $height = $imagen[1];

        # Calculamos el porcentaje para escalar la imagen más optimo, un ancho cercano a los 900px
        for ($i=9; $i > 0; $i--) {

            $prueba = $height * "0.{$i}";

            if($prueba <= 900){
                break;
            }   
        }

        # Con el calculo optimo, calculamos las nuevas dimenciones de la imagen
        $width *= "0.{$i}";
        $height *= "0.{$i}";

        # Creamos una nueva imagen desde la original
        switch ($mime) {
            case 'image/jpeg':
                $img = ImageCreateFromJPEG($ruta);
            break;

            case 'image/png':
                $img = ImageCreateFromPNG($ruta);
            break;

            case 'image/gif':
                $img = ImageCreateFromGIF($ruta);
            break;
        }

        # Crear una nueva imagen con las nuevas dimenciones
        $thumb = imagecreatetruecolor($width,$height);

        # redimensiona la imagen original copiandola en la imagen 
        ImageCopyResized($thumb, $img ,0,0,0,0, $width ,$height,ImageSX($img),ImageSY($img));

        # reemplazamos la imagen original por la nueva
        switch ($mime) {
            case 'image/jpeg':
                ImageJPEG($thumb,$ruta,9);
            break;

            case 'image/png':
                ImagePNG($thumb,$ruta,9);
            break;

            case 'image/gif':
                ImageGIF($thumb,$ruta,9);
            break;
        }

        ImageJPEG($thumb,$ruta,9);
        ImageDestroy($img);

        return true;
        
    }

}


