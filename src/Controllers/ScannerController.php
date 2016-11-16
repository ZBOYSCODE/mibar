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

    public function showAction(){
        if($this->request->isGet()){

            #js custom

            #$this->assets->addJs('js/pages/scanner/webcodecamjquery.js');
            #$this->assets->addJs('js/pages/scanner/mainjquery.js');
            $this->assets->addCss("css/plugins/file-input.css");
            $this->assets->addJs('js/pages/scanner.js');

            $this->view->pick("controllers/scanner/_index");
        }
    }

    public function tableAction () {

        $data = array();

        $nombre = $this->generaNameRandom();


        if ($this->request->hasFiles() == true) {     

            //$fi = new finfo(FILEINFO_MIME, '/usr/share/misc/file/magic');
        
            foreach ($this->request->getUploadedFiles() as $file) {
               
                $ruta = "files/qr/".$nombre.".".$file->getExtension();

                $mime = $file->getType();
                 




                // Move the file into the application
                if (  $result = $file->moveTo($ruta) ){

                    $data['ruta'] = $ruta;


                   
                    
                    if($mime == 'image/jpeg') {

                        $data['mime'] = "JPG";
                        $image = imagecreatefromjpeg ( $ruta );
                        $image = imagescale($image, 1000);
                        imagejpeg($image, $ruta, 0);
                    }

                    if($mime == 'image/png') {
                        $data['mime'] = "PNG";
                        $image = imagecreatefrompng ( $ruta );
                        $image = imagescale($image, 1000);
                        imagepng($image, $ruta, 0);
                    }




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

                    

                    // redirect to login

                    $this->contextRedirect('login');
                
                } else {
                    $data['success'] = false;
                }
            }

            echo "<pre>";
            echo json_encode($data);
        }
    }

    private function readQr($ruta) {

        $QRCodeReader = new \Libern\QRCodeReader\QRCodeReader();
        $qrcode_text = $QRCodeReader->decode( $ruta );

        return $qrcode_text;
    }

    private function generaNameRandom() {

        $fecha  = date('YmdHis');
        $rand   = rand(5, 10000);

        return  $rand."_".$fecha ;
    }

    private function getTableByQr($textqr) {

        $arr = explode('/', $textqr);

        $num = count($arr);

        return $arr[$num-1];

    }

    private  function ImageResize($ruta, $width, $height)
    {

        
    }

}
