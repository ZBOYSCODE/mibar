<?php

namespace App\Controllers;


use App\Business\PedidoBSN;
use App\Business\ProductoBSN;

use App\library\Constants\Constant;




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
               
                $ruta = "files/qr/".$nombre;

                // Move the file into the application
                if (  $result = $file->moveTo($ruta) ){

                    $textqr = $this->readQr($ruta);

                    $mesa = $this->getTableByQr($textqr);

                    if( $this->session->has('table_id_tmp') ) {
                        
                        $this->session->remove('table_id_tmp');
                    }

                    $this->session->set('table_id_tmp', $mesa);

                    $data['success'] = true;

                    $data['redirect'] = $this->config->get('application')['publicUrl'].'login';
                
                } else {
                    $data['success'] = false;
                }
            }

            echo json_encode($data);
        }
    }

    private function readQr($ruta) {

        $QRCodeReader = new \Libern\QRCodeReader\QRCodeReader();
        $qrcode_text = $QRCodeReader->decode( $ruta );

        return $qrcode_text;
    }

    private function generaNameRandom() {

        $fecha  = date('YmdHisu');
        $rand   = rand(5, 10000);

        return  $rand."_".$fecha ;
    }

    private function getTableByQr($textqr) {

        $arr = explode('/', $textqr);

        $num = count($arr);

        return $arr[$num-1];

    }

}
