<?php

namespace App\Controllers;
use App\Models\Turns;
use App\Models\PdfCreator;

use App\Business\UserBSN;
use App\Business\TurnBSN;
use App\Business\AgendaBSN;
use App\Business\PaymentBSN;
use App\Business\ProceduresBSN;
use App\Business\MedicalHistoryBSN;
use App\Models\Process;
use App\Business\BranchOfficeBSN;
use Dompdf\Dompdf;


class TestController extends ControllerBase
{

    public function indexAction()
    {

    	$this->view->pick("test/test_form");

    }

	/**
	 * Crea turnos
	 *
	 * Crea turnos de agendamiento en estado 0, partirá
	 * desde el día del parámetro enviado hasta el 30 del mes
	 * (* No válido para febrero, modificar código)
	 *
	 * @param integer $data['count'] : cantidad de turnos a crear
	 * @param date $data['date'] : dia del mes del cual empezar a crear turnos
	 *
	 *  
	 */
    private function createTurnsAction($param){

        for ($i=0; $i < $param['count'] ; $i++) { 

        	$dt = new \DateTime($param['date']);

			$turn = new Turns();
			$turn->usb_id = mt_rand(1,6);
			$turn->turn_state_id = 1;
			$turn->datetime_turn = $dt->format('Y-m')."-".mt_rand($dt->format('d'),30)." ".mt_rand(9,16).":00:00";

	        //print_r($turn->toArray());
			if($turn->save() == true)
			{
				foreach ($turn->getMessages() as $message) {
					$val = $message->getMessage();
	                echo $val."<br>";
	            }
	        } else{
	        	echo "Turno {$i} fecha: {$turn->datetime_turn} creado correctamente. <br>";
	        }
        }    	

    }





    public function  userListAction(){
        $userBSN = new UserBSN();
        $users = $userBSN->index(array('pagination'=> true, 'role' => 'Especialista'));
        foreach ($users->items as $user){
            echo $user->username . ' ' . $user->role;
            echo "<br><br>";
        }
        echo $users->current;
    }

    public function getUserAction(){
        $userBSN = new UserBSN();
        $user = $userBSN->show(array('id' => 3));
        echo $user['app\Models\Users']->username;
        //var_dump($user);
    }

    public function getTurnsDailyAction(){

    	$data['date'] = '2016-10-06';

    	// En caso de seleccionar un especialista 
    	//$data['usb_id'] = 4;


    	// En caso de no seleccionar especialista
    	$data['specialty_id'] = 6;
    	$data['branchOffice_id'] = 1;

    	$agendaBSN = new AgendaBSN();
    	$result = $agendaBSN->getDailyTurns($data);
    }

    public function getTurnsWeeklyAction(){

    	$data['date'] = '2016-10-06';
    	$data['usb_id'] = 1;

    	$agendaBSN = new AgendaBSN();
    	$result1 = $agendaBSN->getWeeklyTurns($data);
        print_r($agendaBSN->error);
    	$result2 = $agendaBSN->getDaysOfWeekTurn($data);
        print_r($agendaBSN->error);
    	print_r($result1);
    	print_r($result2);    	
    }


    public function turnScheduleAction(){

        /* CREATE ACTIVADO
    	$data['create'] = 1;
    	$data['turn_id'] = 2;
        $data['data'] = array(
                'firstname' => 'firstname',
                'lastname' => 'lastname',
                'rut' => 'rut',
                'location' => 'location',
                'phone_fixed' => 'phone_fixed',
                'phone_mobile' => 'phone_mobile',
                'medical_plan_id' => '1',
                'email' => 'paciente@prueba.cl'
            );

            */

        /* CREATE DESACTIVADO (SOLO UPDATE)

        $data['turn_id'] = 2;
        $data['data'] = array(
                'patient_id' => 103,
                'rut' => 'rut_mod',
                'phone_fixed' => 'phone_fixed_mod',
                'medical_plan_id' => '2'
            );        

        */

		$agendaBSN = new AgendaBSN();
		$result = $agendaBSN->storeTurnSchedule($data);
		print_r($agendaBSN->error);
    }

    public function turnConfirmAction()
    {
        $data['turn_id'] = 2;
        $data['data'] = array(
                'patient_id' => 103,
                'rut' => 'rut',
                'phone_fixed' => 'phone_fixed_remod',
                'medical_plan_id' => '1'
            );        

        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->storeTurnConfirm($data);
        print_r($agendaBSN->error);        
    }

    public function turnReceptionAction()
    {
        $data['turn_id'] = 2;
        $data['data'] = array(
                'patient_id' => 103,
                'phone_fixed' => 'phone_fixed_final'
            );        

        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->storeTurnReception($data);
        print_r($agendaBSN->error);        
    }    

    public function turnPaymentAction()
    {
        $data['turn_id'] = 517;
        $data['data'] = array(
                'payment_category_id' => 1,
                'medical_plan_id' => '1',
                'total' => '10000'
            );        
        $data['agreements'] = array(1);
        $data['payment_details'] = array(
                                           array("payment_id" => 1,
                                                 "payment_method_id" =>1,
                                                 "amount" => 10000
                    )
            );


        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->storeTurnPayment($data);
        print_r($agendaBSN->error);   
    }      


    public function getSchedule(){
        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->index();
        print_r($result->toArray());
    }

    public function paymentmethodsAction(){
        $paymentBSN = new PaymentBSN();
        $result = $paymentBSN->getPaymentMethods();
        print_r($result->toArray());

    }

    public function getSpecialistsUSBAction(){
    	$data['specialty_id'] = 1;
    	$data['branchOffice_id'] = 1;

        $userBSN = new UserBSN();
        $result = $userBSN->getListSpecialistUSB($data);

        //Ejemplo para acceder a details
        //print_r($result->getFirst()->Users->UserDetails->getFirst()->firstname);
    }

    public function getTurnAction(){
    	//$data['turn_id'] = 4;
    	$data['datetime'] = "2016-09-21 13:00:00";
    	$turnBSN = new TurnBSN();
    	$result = $turnBSN->getTurn($data);
    	print_r($result);
    	print_r($turnBSN->error);
    }


    public function getcitiesbydistrictsAction($districtId){

        $userBSN = new UserBsn();
        $response = $userBSN->getCitiesByDistricts($districtId);

        print_r($response);

    }

    public function getdistrictsAction(){

        $userBSN = new UserBsn();
        $response = $userBSN->getDistricts();

        print_r($response->toArray());

    }



    public function getTurnsAlternativeAction()
    {
        $param['turn_id'] = 1;
        $param['count'] = 3;
        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->getTurnsAlternative($param);
        print_r($result);
        print_r($agendaBSN->error);
    }


    public function getPaymentCategoriesAction()
    {
        $paymentBSN = new PaymentBSN();
        $result = $paymentBSN->getListPaymentCategories();
        print_r($result->toArray());
        print_r($paymentBSN->error);
    }

    public function getBenefitsAction()
    {
        $paymentBSN = new PaymentBSN();
        $result = $paymentBSN->getListBenefits();
        print_r($result->toArray());
        print_r($paymentBSN->error);     
    }

    public function getAgreementsAction(){
        $param['medical_plan_id'] = 1;
        $param['user_id'] = 1;
        $param['specialty_id'] = 1;
        $param['turn_attention_id'] = 1;

        $paymentBSN = new PaymentBSN();

        
        $result = $paymentBSN->getListAgreements($param);


        if($result!=false){

        print_r($result->toArray());

        }
        print_r($paymentBSN->error);   

      
    }


    public function getconfirmationcategoriesAction(){
        $turnBSN = new TurnBSN();
        $result = $turnBSN->getConfirmationCategories();

        print_r($result->toArray());
    }

    public  function listTurnConfigAction(){
        $turnBSN = new TurnBSN();
        $result = $turnBSN->listConfigurations(array('user_id' => 1,
            'specialty_id'=> 1));
        foreach ($result as $var) {
            $temp = $var->toArray();
            foreach ($temp as $value) {
                echo  ' <br>';
                foreach ($value as $key=>$item) {
                    echo '*' . $key . ' : ' . $item . '<br>';
                }
            }
            echo ' <br>';
        }
    }


    public function editMobileTemporaAction() {
        #js custom
        $this->assets->addJs('js/pages/mobileedite.js');
        $this->view->pick("controllers/patient/editmobile/_index");
    }



    public  function deleteTurnConfigAction(){
        $turnBSN = new TurnBSN();
        $result = $turnBSN->deleteConfiguration(2);
        echo $result;
    }

    public function generatePdfAction() {

        $done = $this->pdfcreator->createFromTemplate(
            'test', array('name'=>'Jorge', 'lastname' => 'Cociña'));
        if($done)
        {
            echo 'creado';
        }
        else {
            echo 'error';
        }
    }

    public function pdfcreateAction(){  
        

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();



        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <title>Turnos test</title>
                        <style type="text/css" >
                          .table {
                              display: table;
                              height:200px;
                              width:200px;
                              margin: 0 auto;
                          }
                          .tr {
                              display: table-row;
                          }
                          .highlight {
                              background-color: greenyellow;
                              display: table-cell;
                          }
                          p{
                            text-align: center;
                          }
                        </style>
                    </head>
               <body>
                <!-- NO MORE CRASH HERE -->
                
                <p>Here is <span class="table"><span class="tr"><span class="highlight">a span</span></span></span> with no padding.</p>

                </body>
            </html>' ;

        
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $fecha = (string)date("d-m-Y");
        $dompdf->stream("Turno ".$fecha);

    }

    public function bloqueaturnoAction($param){

        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->blockTurnbyId($param);
        print_r($agendaBSN->error);
        if($result){
            echo "Exito";
        }else{
            echo "Problemas";
        }
    }

    public function anulaturnoAction(){
        $param['turn_id'] = 517;
        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->cancelTurnbyId($param);
        print_r($agendaBSN->error);
        if($result){
            echo "Exito";
        }else{
            echo "Problemas";
        }
    }

    public function getproceduresAction(){
        $proceduresBSN = new ProceduresBSN();
        $result = $proceduresBSN->getProcedures();

        
        print_r($result->toArray());
    }


    public function getbenefitsbyprocedureidAction($param){
        $proceduresBSN = new ProceduresBSN();
        $result = $proceduresBSN->getProcedure($param);

        echo "<pre> Procedure";
        print_r($result->toArray());

        echo "<br>ProcedureBenefits";
        print_r($result->ProcedureBenefits->toArray());

        echo "<br>Benefits";

        foreach ($result->ProcedureBenefits as $ProcedureBenefits) {

            print_r($ProcedureBenefits->Benefits->toArray());
        
        }

    }

    public function getavailableexamsAction(){
        
        $param['procedure_id']=1;
        $param['date']= "2016-09-21 14:00:00";
        $param['limit']=5;
        $agendaBSN = new AgendaBSN();
        $result = $agendaBSN->getAvailableSoonExamsByProcedureId($param);

        print_r($result);
        print_r($agendaBSN->error);
    }


    public function swaltestAction(){

        $this->mifaces->newFaces();





        $config = [
            "type" => "warning",
        ];


        $view = "controllers/scheduling/reception/swal_confirm";
        $toRend = $this->view->getPartial($view);


        $this->mifaces->addToSwalRend($config, $toRend);






        $this->mifaces->run();

    }



    public function storeturnovercrowdAction(){

        //Creando un usuario
        $param['create'] = 1;
        $param['data']['email']='rorigo.s.c.1994@gmail.com';
        $param['data']['patient_id']=11;
        $param['data']['phone_fixed']= 12312312;
        $param['data']['phone_mobile'] = 12312312;
        $param['data']['medical_plan_id'] = 1;
        $param['data']['firstname']="Rodrigo";
        $param['data']['lastname']="Soto";
        $param['data']['rut']= "18.7083.549-k";
        $param['data']['location'] = "Viña del Mar";
        $param['data']['medical_plan_id']=1;

        $param['turn']['usb_id'] = 1;
        $param['turn']['turn_category_id']= 1;
        $param['turn']['datetime_turn']= "2016-09-15 09:00:00";
        $param['turn']['turn_configuration_id']=0;

        $agendaBSN = new AgendaBSN();

        $result = $agendaBSN->storeTurnOvercrowd($param);
        
        print_r($result);

    }

    public function getagreementbyidAction($parametro){

        $param['agreement_id']=$parametro;

        $agendaBSN = new AgendaBSN();

        $agreements = $agendaBSN->getAgreementbyId($param);

        if($agreements != false){
            print_r($agreements->toArray());
        }else{
            print_r($agendaBSN->error);
        }
    }

    public function hmpdfAction() {

            $param = [
                "nombre" => "Hoja de Agendamiento Diario"
            ];

            $this->pdfcreator->createFromTemplate('mh', $param, 'MedicalHistory');

        }    


    public function initAttentionAction(){
        $param['turn_id'] = 3;
        $medicalBSN = new MedicalHistoryBSN();
        $medicalBSN->initAttention($param);
    }

    public function finishAttentionAction(){    
        $param['turn_id'] = 3;
        $medicalBSN = new MedicalHistoryBSN();
        $medicalBSN->finishAttention($param);
    }    


    public function getTimelineAction(){
        $param['user_patient_id'] = 12;
        $param['specialty_id'] = 1;
        $medicalBSN = new MedicalHistoryBSN();
        $medicalBSN->getTimeline($param);

    }


    public function editUserAction(){

        $param['email'] = 'ssilvac@zmed.cl';
        $param['user_id'] = 1;

        $userBSN = new UserBSN();
        $result = $userBSN->editUser($param);
        print_r($result);
    }

    public function getListMedicalHistoryTypeBySpecialtyAction(){
        $param['specialty_id'] = 6;
        $medicalBSN = new MedicalHistoryBSN();
        $result = $medicalBSN->getListMedicalHistoryTypeBySpeciality($param);
        print_r($result->toArray());
    }



    public function creaConfTurnAction(){

        $param['config']['date_ini'] = "2016-12-01";
        $param['config']['date_end'] = "2016-12-05";
        $param['config']['hour_ini'] = "9:00";
        $param['config']['hour_end'] = "18:00";
        $param['config']['interval'] = 30;

        $days = array("1" => true,
                      "2" => true,
                      "3" => true,
                      "4" => true,
                      "5" => true,
                      "6" => false,
                      "7" => false
                );

        $param['config']['days'] = json_encode($days);
        $param['config']['hour_ini_restriction'] = "14:00:00" ;
        $param['config']['hour_end_restriction'] = "15:00:00" ;
        $param['turn']['especialty_id'] = 6;
        $param['turn']['user_id'] = 1;
        $param['turn']['branch_office_id'] = 1;
        $param['turn']['turn_attention_id'] = 1;

        $turnBSN = new TurnBSN();

        $result = $turnBSN->createTurnConfiguration($param);

        echo $result;

        print_r($turnBSN->error);


    }

    public function traelistaAction(){

        $paymentBSN = new PaymentBSN();

        $result = $paymentBSN->getListBenefits();

        print_r($result);
        print_r($paymentBSN->error);

    }

    public function pruebapruebaAction(){

        $result =  Process::find();

        var_dump($result->count());

        if(!$result->count()){
            echo "Retorna False";
            echo "<br>";
            print_r($result);

        }else{
           echo "Retorna otros datos";
           echo "<br>";
           print_r($result);
        }
        

    }

    public function pruebaprueba2Action(){

        $phql = "SELECT * FROM App\Models\Process";

        $result = $this->modelsManager->createQuery($phql)
              ->execute();

        var_dump($result->count());

        if(!$result->count()){
            echo "Retorna False";
            echo "<br>";
            print_r($result);

        }else{
           echo "Retorna otros datos";
           echo "<br>";
           print_r($result);
        }
    }
    

    public function ValidateFormAction(){
       
        $this->mifaces->newFaces();
        $post = $this->request->getPost();

        //print_r($post);exit();
        foreach ($post as $key => $value) {

            $arreglo[] =array($key,"*Campo Requerido");
        }

        $this->mifaces->addErrorsForm($arreglo);
        $this->mifaces->run();
    }

    public function pruebaprueba3Action(){
        echo "Prueba";
        $proceduresBSN = new ProceduresBSN();
        $result = $proceduresBSN->getProcedure(500);
        print_r($result);
        print_r($proceduresBSN->error);
    }

    public function pruebaprueba4Action(){
        echo "Prueba 4";
        $branchOfficeBSN = new BranchOfficeBSN();

        $result = $branchOfficeBSN->getBranchOffices();

        print_r($result);

    }

}