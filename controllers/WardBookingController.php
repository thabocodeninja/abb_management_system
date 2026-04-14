<?php
require_once __DIR__ . '/../models/WardBooking.php';
require_once __DIR__ .'/../models/Patient.php';
require_once __DIR__. '/../models/Ward.php';



class WardBookingController extends BaseController {
    public function index() {
        $this->checkRole('admin');
        $wardBookingModel = new WardBooking();
        $wardBookings = $wardBookingModel=>getAllWardBookings();
        $this->render('ward-bookings/index', ['wardBookings' => $wardBookings])
    }

    public function create() {
        $this->checkRole('admin');
        $patientModel = new Patient();
        $wardModel = new Ward();
        $patients = $patientModel->getAllPatients();
        $wards = $wardModel->getAvailableWards();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = [
                'patient_id' => $_POST['patient_id'],
                'ward_id' => $_POST['ward_id'],
                'booking_date' => $_POST['booking_date'],
                'discharge_date' => $_POST['discharge_date'],
                'notes' => $_POST['notes']
            ];

            $wardBookingModel = new WardBooking();
            if ($wardBookingModel->create($data)){
                $this->redirect('ward-bookings')
            }
        }
        $this->render('ward-bookings/create', ['patients' => $patients, 'wards' => $wards])
    }

    public function edit($id) {
        $this->checkRole('admin');
        $wardBookingModel = new WardBooking();
        $patientModel = new Patient();
        $wardModel = new Ward;
        $wardBooking = $wardBookingModel=>getById($id);
        $patients = $patientModel->getAllPatients();
        $wards = $wardBookingModel->getAllWardBookings();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'ward_id' => $_POST['ward_id'],
                'booking_date' => $_POST['booking_date'],
                'discharge_date' => $_POST['discharge_date'],
                'notes' => $_POST['notes']
            ];
            if ($wardBookingModel->update($id,$data)){
                $this->redirect('/ward-bookings');
            }
        }
        $this->render('ward-bookings/edit', ['wardBooking' => $wardBooking],
         'patients' => $patients, 'wards' => $wards)
    }
    
    public function delete($id) {
        $this->checkRole('admin');
        $wardBookingModel = new WardBooking();
        if($wardBookingModel->delete($id)) {
            $this->redirect('ward-bookings')
        }
    }
}

?>