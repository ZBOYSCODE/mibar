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

            $this->assets->addJs('js/pages/scanner/webcodecamjquery.js');
            $this->assets->addJs('js/pages/scanner/mainjquery.js');

            $this->view->pick("controllers/scanner/_index");
        }
    }


}
