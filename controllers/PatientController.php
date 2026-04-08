<?php

require_once __DIR__. '/../models/Patient.php';
require_once __DIR__. '/../models/User.php';


class PatientController extends BaseController {
    public function index() {
        $this->checkRole('admin');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;


        $patientModel = new Patient();
        $patients = $patientModel->getAll($limit, $offset);
        $total = $patientModel->getTotalCount();
        $totalPages = ceil($total / $limit);

        $this->render('patients/index', ['patients' => $patients, 'page' => $page, 'totalPages' => $totalPages]);
    }

    public function create() {
        $this->checkRole('admin');
        $userModel = new User();
        $users = $userModel->getAllUsers();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'user_id' => $_POST['user_id'],
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'dob' => $_POST['dob'],
                'gender' => $_POST['gender'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'emergency_contact' => $_POST['emergency_contact'],
                'admission_date' => $_POST['admission_date']
            ];
            $patientModel = new Patient();
            if($patientModel->create($data)){
                $this->redirect('/patients');
            }
        }
        $this->render('patients/create', ['users' => $users]);
    }
}


public function edit($id) {
    $this->checkRole('admin');
    $patientModel = new Patient();
    $userModel = new User();
    $patient = $patientModel->getById($id);
    $users = $userModel->getAllUsers();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'dob' => $_POST['dob'],
            'gender' => $_POST['gender'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'emergency_contact' => $_POST['emergency_contact'],
            'admission_date' => $_POST['admission_date'],
            'status' => $_POST['status']
        ]

        if($patientModel->update($id,$data)){
            $this->redirect('/patients');
        }
    }
    $this->render('patients/edit', ['patient' => $patient, 'users' => $users])
}

public function delete($id) {
    $this->checkRole('admin');
    $patientModel = new Patient();
    if ($patientModel->delete($id)) {
        $this->redirect('/patients');
    }
}

?>


