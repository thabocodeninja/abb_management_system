<?php

require_once __DIR__. '/../models/MedicalRecord.php';
require_once __DIR__. '/../models/Patient.php';
require_once __DIR__. '/../models/User.php';


class MedicalRecordController extends BaseController {
    public function index(){
        $this->checkRole('admin');
        $medicalRecordModel = new MedicalRecord();
        $medicalRecords = $medicalRecordModel->getAllMedicalRecord();
        $this->remder('medical-records/index', ['medicalRecords' => $medicalRecords]);
    }


    public function create() {
        $this->checkRole('admin');
        $patientModel = new Patient();
        $userModel = new User();
        $patients = $patientModel->getAllPatient();
        $doctors = $userModel->getUsersByRole('doctor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'],
                'record_date' => $_POST['record_date'],
                'diagnosis' => $_POST['diagnosis'],
                'treatment' => $_POST['treatment'],
                'notes' => $_POST['notes']
            ];
            $medicalRecordModel = new MedicalRecord();
             if ($medicalRecordModel->create($data)) {
                $this->redirect('/medical-records');
             }
        }
        $this->render('medical-records/create', ['patients' => $patients, 'doctors' => $doctors])
    }


    public function edit($id) {

     $this->checkRole('admin');
     $medicalRecordModel = new MedicalRecord();
     $patientModel = new Patient();
     $userModel = new User();
     $medicalRecord = $medicalRecordModel->getById($id);
     $patients = $patientModel->getAllPatient();
     $doctors = $userModel->getUsersByRole('doctor') 
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'record_date' => $_POST['record_date'],
            'diagnosis' => $_POST['diagnosis'],
            'treatment' => $_POST['treatment'],
            'notes' => $_POST['notes']
        ];
        if ($medicalRecordModel->update($id, $data)) {
            $this->redirect('/medical-records')
        }
     }

     $this->render('medical-records/edit', ['medicalRecord' => $medicalRecord, 'patients' => $patients, 'doctors' => $doctors])
    }

    public function delete($id) {
        $this->checkRole('admin');
        $medicalRecordModel = new MedicalRecord();
         if ($medicalRecordModel->delete($id)) {
            $this->redirect('/medical-records')
         }
    }
}


?>