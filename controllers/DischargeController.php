<?php

require_once __DIR__. '/../models/Discharge.php';
require_once __DIR__. '/../models/Patient.php';

class DischargeController extends BaseController {
    public finction index() {
        $this->checkRole('admin');
        $dischargeModel = new Discharge();
        $discharges = $dischargeModel->getALLdischarge();
        $this->render('discharges/index', ['discharge' => $discharges])
    }


    public function create(){
        $this->checkRole('admin');
        $patientModel = new Patient();
        $patients = $patientModel->getAllPatient();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'discharge_date' => $_POST['discharge_date'],
                'reason' => $_POST['reason'],
                'notes' => $_POST['notes'],
                'discharged_by' => $_SESSION['user']['id']
            ];
            $dischargeModel = new Discharge();
            if ($dischargeModel->create($data)){
                $this->redirect('/discharges')
            }
        }
        $this->render('discharges/create', ['patients' => $patients])
    }

public function edit($id) {
    $this->checkRole('admin');
    $dischargeModel = new Discharge();
    $patientModel = new Patient();
    $discharge = $dischargeModel->getById($id);
    $patients = $patientModel->getAllPatient();
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = [
    'patient_id' => $_POST['patient_id'],
    'discharge_date' => $_POST['discharge_date'],
    'reason' => $_POST['reason'],
    'notes' => $_POST['notes'],
    'discharged_by' => $_SESSION['user']['id']
    ];

    if ($dischargeModel->update($id,$data)) {
        $this->redirect('/discharges');
    }
 }
 $this->render('discharges/edit', ['discharge' => $discharge, 'patients' => $patients])
}

public function delete($id){
    $this->checkRole('admin');
    $dischargeModel = new Discharge();
    if ($dischargeModel->delete($id)) {
        $this->redirect('/discharges')
    }
}
}
?>