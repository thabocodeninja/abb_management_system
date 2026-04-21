<?php


require_once __DIR__. '/../models/Prescription.php';
require_once __DIR__. '/../models/Patient.php';
require_once __DIR__. '/../models/User.php';


class PrescriptionController extends BaseController {
    public function index() {
        $this->checkRole('admin');
        $prescriptionModel = new Prescription();
        $prescriptions = $prescriptionModel->getAllPrescription();
        $this->render('prescription/index', ['prescriptions' => $prescriptions])
    }

 
    public function create() {

    $this->checRole('admin');
    $patientModel = new Patient();
    $userModel = new User();
    $patients = $patientModel->getAllPatient();
    $doctors = $userModel->getUsersByRole('doctor');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'prescription_date' => $_POST['prescription_date'],
            'medication' => $_POST['medication'],
            'dosage' => $_POST['dosage'],
            'instructions' => $_POST['instructions']
        ]
        $prescriptionModel = new Prescription();
        if ($prescriptionModel->create($data)) {
            $this->redirect('/prescriptions');
        }
    }
    $this->render('prescriptions/create', ['patients' => $patients, 'doctors' => $doctors])
    }

    public function edit($id) {
        $this->checkRole('admin');
        $prescriptionModel = new Prescription();
        $patientModel = new Patient();
        $userModel = new User();
        $prescription = $prescriptionModel->getById($id);
        $patients = $patientModel->getAllPatient();
        $doctors = $userModel->getUsersByRole('doctor');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'],
                'prescription_date' => $_POST['prescription_date'],
                'medication' => $_POST['medication'],
                'dosage' => $_POST['dosage'],
                'instructions' => $_POST['instructions']
            ]
            if ($prescriptionModel->update($id,$data)) {
                $this->redirect('/prescriptions')
            }
        }
        $this->render('prescriptions/edit' , ['prescription' => $prescription, 'patients' => $patients, 'doctors' => $doctors])
    }

    public function delete($id) {
        $this->checkRole('admin');
        $prescriptionModel = new Prescription();
        if ($prescriptionModel->delete($id)) {
            $this->redirect('/prescriptions')
        }
    }
}


?>
