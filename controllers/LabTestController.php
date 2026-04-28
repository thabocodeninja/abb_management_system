<?php

require_once __DIR__. '/../models/LabTest.php';
require_once __DIR__. '/../models/Patient.php';
require_once __DIR__. '/../models/User.php';

class LabTestController extends BaseController {
     public function index() {
        $this->checkRole('admin');
        $labTestModel = new LabTest();
        $this->render('lab-tests/index', ['labTests' => $labTests]);
     }

     public function create() {
        $this->checkRole('admin');
        $patientModel = new Patient();
        $userModel = new User();
        $patients = $patientModel->getAllPatient();
        $technicians = $labTestModel->getAllLabTest();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'patient_id' => $_POST['patient_id'],
                'test_name' => $_POST['test_name'],
                'test_date' => $_POST['test_date'],
                'result' => $_POST['result'],
                'technician_id' => $_POST['technician_id']
            ]
            $labTestModel = new LabTest();
            if ($labTestModel->create($data)) {
                $this->redirect('lab-tests')
            }
        }
    $this->render('lab-tests/create', ['patients' => $patients, 'technicians' => $technicians])
     }

  
     

}


?>