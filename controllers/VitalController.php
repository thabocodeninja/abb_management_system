<?php

require_once __DIR__. '/../models/Vital.php';
require_once __DIR__. '/../models/Patient.php';


class VitalController extends BaseController {

  public function index() {
   $this->checkRole('admin');
   $vitalModel = new Vital();
   $vitals = $vitalModel->getAllVital();
   $this->render('vitals/index' , ['vitals' => $vitals])
}

public function create(){
    $this->checkRole('admin');
    $patientModel = new Patient();
    $patients = $patientModel->getAllPatient();
    if ($_SERVER['REQUEST_METHOD'] ==='POST') {
        $data[
        'patient_id' => $_POST['patient_id'],
        'recorded_date' => $_POST['recorded_date'],
        'blood_pressure' => $_POST['blood_pressure'],
        'temperature' => $_POST['temperature'],
        'heart_rate' => $_POST['heart_rate'],
        'recorded_by' => $_SESSION['user']['id']
        ];
        $vitalModel = new Vital();
         if ($vitalModel->create($data)){
            $this->redirect('/vitals')
         }
    }
    $this->render('vitals/create', ['patients' => $patients])
}


public function edit($id) {
    $this->checkRole('admin');
    $vitalModel = new Vital();
    $patientModel = new Patient();
    $vital = $vitalModel->getById($id);
    $patients = $patientModel->getAllPatient();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = [
            'patient_id' => $_POST['patient_id'],
            'recorded_date' => $_POST['recorded_date'],
            'blood_pressure' => $_POST['blood_pressure'],
            'temperature' => $_POST['temperature'],
            'heart_rate' => $_POST['heart_rate'],
            'recorded_by' => $_SESSION['user']['id']
        ];

        if ($vitalModel->update($id, $data)) {
            $this->render('/vitals')
        }
    }
    $this->render('vitals/edit', ['vital' => $vital, 'patients' => $patients])
}
public function delete($id){
    $this->checkRole('admin');
    $vitalModel = new Vital();
    if ($vitalModel->delete($id)) {
        $this->redirect('/vitals')
    }
}
}

?>