<?php

namespace App\Controllers;






class BartenderController extends ControllerBase
{

    /**
     * indexAction
     *
     * @author Jorge Silva
     *
     * Index de la pagina de bar, renderiza los pedidos pendientes.
     *
     */
    public function indexAction()
    {
        #js custom
        $this->assets->addJs('js/pages/bartender.js');

        #View
        $this->view->pick("controllers/bartender/_index");
    }


    /**
     * getOrdersAction
     *
     * @author Jorge Silva
     *
     * @param $_POST
     *
     * Método para mostrar ordenes al barman recibe por post un tipo ya sea pendientes o listos
     *
     * retorna vista json via mifaces
     */
    public function getOrdersAction()
    {
        if($this->request->isAjax()){

            //nothing

        }
        else {
            $this->defaultRedirect();
        }
    }

}