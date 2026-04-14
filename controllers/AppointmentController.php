<?php

require_once __FILE__.'/../models/Appointment.php';
require_once __DIR__.'/../models/Patient.php';
require_once __DIR__. '/../models/User.php';




class AppointmentController extends baseController {
    public function index() {
        $this->checkRole(['admin']);
        $appointmentModel = new Appointment();
        $appointments = $appointmentModel->getAllAppointments();
        $this->render('appointments/index', ['appointments' => $appointments])
    }

    public function create(){
        $this->checkRole('admin');
        $patientModel = new Patient();
        $userModel = new User();
        $patients = $patientModel->getAllPatients();
        $doctors = $userModel->getUsersByRole('doctor');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'],
                'appointment_date' => $_POST['appointment_date'],
                'notes' => $_POST['notes']
            ]
            $appointmentModel = new Appointment();
             if ($appointmentModel->create($data)) {
                $this->redirect('/appointments');
             }
        }
        $this->render('appointments/create', ['patients' => $patients, 'doctors' => $doctors])

    }
 public function edit($id){
    $this->checkrole('admin');
    $appointmentModel = new Appointment();
    $patientModel = new Patient();
    $userModel = new User()
    $appointments = $appointmentModel->getById($id)
    $patients = $patientModel->getAllPatients();
    $doctors = $userModel->getUsersByRole('doctor');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'appointment_date' $_POST['appointment_date'],
            'notes' => $_POST['notes']
        ];
        if ($appointmentModel->update($id, $data)) {
            $this->redirect('/appointments')
        }
    }
    $this->render('appointments/edit', ['appointment' => $appointments, 'patients' => $patients, 'doctor' => $doctors])
    }

    public function delete($id) {
        $this->checkRole('admin');
        $appointmentModel = new Appointment();
        if ($appointmentModel->delete($id)) {
            $this->redirect('/appointments')
        }
    }



?>